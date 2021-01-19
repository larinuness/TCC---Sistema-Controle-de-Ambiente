<?php

use Application\core\Controller;

class RelatorioController extends Controller
{
    public function index()
    {
        session_start();

        if (isset($_SESSION['usuario'])) {//&& $_SESSION['kaa_session_validity'] > date("d-m-Y h:i:s P")) {
            $id = $_SESSION['usuario']->id;
        }
        else{
            header('Location: /painel/');
        }


        $tipGad = $this->model('TipoGadget');

        $retorno = $tipGad->buscaTipoGadgetUsuario($id);

        if(!$retorno['isError']) {

            $this->view('relatorio/index', $retorno[0]);
        }else{
            $this->view('erro',$retorno);
        }
    }

    /**
     * @param string $tr
     * @param int $tm
     * @param bool $rel
     */
    public function grafico($tr = 'DIA', $tm = 1, $rel = false)
    {
        session_start();

        date_default_timezone_set('America/Sao_Paulo');
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']->id;
        } else {
            header('Location: /painel/');
        }

        $vwRel = $this->model('VwRelatorio');

        $retorno = $vwRel->buscaLabelsCharts($id, $tr, $tm);

        if (!$retorno['isError']) {
            $labels = [];
            foreach ($retorno[0] as $item) {
                array_push($labels, $item->data_hora);
            }
            $retorno2 = $vwRel->buscaDatasetCharts($id, $tr, $tm);

            if (!$retorno2['isError']) {
                if ($rel) {
                    $arq = [];
                    foreach ($retorno2[0] as $item) {
                        array_push($arq, ["label" => $item->label, "data_hora" => $item->data_hora, "valor" => $item->valor]);
                    }
                    $this->download_send_headers("relatorio_" . date("d-m-Y_H_i_s") . "." . strtolower($rel));
                    echo $this->array2csv($arq, $rel);
                    die();
                } else {
                    $d = [];
                    $data = [];
                    $aux = '';
                    foreach ($retorno2[0] as $linha) {
                        if ($aux == '') {
                            $aux = $linha->label;
                        } elseif ($aux != $linha->label) {
                            $rgb = $this->randomRGB();
                            $dataset = ["label" => $aux, "backgroundColor" => $rgb,
                                "borderColor" => $rgb,
                                "fill" => false, "data" => $d];
                            array_push($data, $dataset);
                            $d = [];
                            $aux = $linha->label;
                        }
                        array_push($d, $linha->valor);
                    }
                    if ($aux != $dataset["label"]) {
                        $rgb = $this->randomRGB();
                        $dataset = ["label" => $aux, "backgroundColor" => $rgb,
                            "borderColor" => $rgb,
                            "fill" => false, "data" => $d];
                        array_push($data, $dataset);
                    }

                    $this->view('relatorio/grafico', [$labels, $data]);
                }
            } else {
                $this->view('erro', $retorno2);
            }

        } else {
            $this->view('erro', $retorno);
        }
    }


    /**
     * @return string
     */
    private function randomRGB()
    {
        $rgbColor = array();

        foreach (array('r', 'g', 'b') as $color) {
            //Generate a random number between 0 and 255.
            $rgbColor[$color] = mt_rand(0, 255);
        }

        return 'rgb(' . $rgbColor['r'] . ',' . $rgbColor['g'] . ',' . $rgbColor['b'] . ')';
    }

    /**
     * @param $array
     * @param $file
     * @return false|string|null
     */
    private function array2csv(&$array, $file)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $ext = ';';
        switch ($file) {
            case 'XLS':
                $ext = chr(9);
                break;
            case 'CSV':
                break;
        }


        $df = fopen("php://output", 'w');
        fputcsv($df, array('Gadget', 'Data', 'Valor Medio'), $ext);
        foreach ($array as $row) {
            $row['valor'] = strval($row['valor']);
            if (strstr($row['valor'], '.')) {
                $row['valor'] = str_replace('.', ',', $row['valor']);
            }
            fputcsv($df, $row, $ext);
        }
        fclose($df);
        return ob_get_clean();
    }

    /**
     * @param $filename
     */
    private function download_send_headers($filename)
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

}