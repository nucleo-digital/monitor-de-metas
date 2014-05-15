<?php

namespace Pdm;

class PaginaInicial
{
    public static function get_context()
    {
        $context = \Timber::get_context();
        $api = new ApiClient;
        $context['metas'] = $api->getMetasFiltradas($projeto_id);
        $context['subprefeituras'] = $api->getSubPrefeituras();
        $context['objetivos'] = $api->getObjetivos();
        $context['secretarias'] = $api->getSecretarias();
        // $context['eixos'] = $api->getEixos();
        // $context['articulacoes'] = $api->getArticulacoes();
        // $context['labels'] = $api->getLabels();

        $context['subprefeitura'] = $_GET['subprefeitura'];
        $context['objetivo'] = $_GET['objetivo'];
        $context['secretaria'] = $_GET['secretaria'];
        $context['status'] = $_GET['status'];
        // $context['eixos'] = $_GET['eixos'];
        // $context['articulacoes'] = $_GET['articulacoes'];
        // $context['labels'] = $_GET['labels'];


        $context['total_metas'] = count($context['metas']);

        if (count($_GET) > 0) {
            $context['filtros_usados'] = array();

            if (!empty($_GET['subprefeitura'])) {
                foreach ($context['subprefeituras'] as $key => $value) {
                    if ($value['id']==$context['subprefeitura']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Subprefeitura: ' . $name;
            }

            if (!empty($_GET['objetivo'])) {
                foreach ($context['objetivos'] as $key => $value) {
                    if ($value['id']==$_GET['objetivo']) {
                        $name = $value['description'];
                    }
                }
                $context['filtros_usados'][] = 'Objetivo: ' . $name;
            }

            if (!empty($_GET['secretaria'])) {
                foreach ($context['secretarias'] as $key => $value) {
                    if ($value['id']==$_GET['secretaria']) {
                        $name = $value['name'];
                    }
                }
                $context['filtros_usados'][] = 'Secretaria: ' . $name;
            }

            if (!empty($_GET['status'])) {
                if (1==$_GET['status']) {
                    $name = 'Não iniciada';
                } elseif (2==$_GET['status']) {
                    $name = 'Em andamento';
                } elseif (3==$_GET['status']) {
                    $name = 'Já beneficiam a população';
                } elseif (4==$_GET['status']) {
                    $name = 'Concluídas';
                }
                $context['filtros_usados'][] = 'Situação: ' . $name;
            }
        }


        $context['subprefeitura_active'] = $_GET['subprefeitura'];
        if (!empty($_GET['subprefeitura'])) {
            $context['filtro_so_subprefeitura'] = 'sim';
        }
        return $context;
    }

    public static function buscaPorCoordenada($lat, $long)
    {
        $api = new ApiClient;
        return $api->getSubPrefeiturasPorCoordenadas($lat, $long);
    }

    public static function metaFollow($params)
    {
        $api = new ApiClient;

        $valid = false;
        if ((!empty($params['name'])) &&
            (!empty($params['email']))) {

            $valid = true;
        }

        if (($valid) && ($api->seguirMeta($params['meta'], $params['name'], $params['email']))) {
            return '<h4>Olá ' . $params['name'] . ', seu e-email ' . $params['email'] .
                   ' foi incluído com sucesso</h4>';
        } else {
            return 'Falha ao tentar cadastrar seu email. Verifique seus dados e tente novamente.';
        }
    }
}
