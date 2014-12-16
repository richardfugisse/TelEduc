<?php
$ferramenta_geral = 'geral';
$ferramenta_agenda = 'agenda';
$ferramenta_administracao = 'administracao';

$model_geral = '../../'.$ferramenta_geral.'/models/';
$model_agenda = '../../'.$ferramenta_agenda.'/models/';
$ctrl_agenda = '../../'.$ferramenta_agenda.'/controllers/';
$view_agenda = '../../'.$ferramenta_agenda.'/views/';
$view_administracao = '../../'.$ferramenta_administracao.'/views/';
$diretorio_jscss = '../../../web-content/js-css/';
$diretorio_imgs = '../../../web-content/imgs/';

require_once $model_geral.'geral.inc';
require_once $model_agenda.'agenda.inc';

$cod_ferramenta=1;

$cod_curso = $_GET['cod_curso'];

$cod_usuario = $_GET['cod_usuario'];

$cod_item = $_GET['cod_item'];

require_once $view_administracao.'topo_tela.php';

if (!Usuarios::EFormador($sock,$cod_curso,$cod_usuario))
{
	echo("  </head>");
	echo("  <body link=\"#0000ff\" vlink=\"#0000ff\" bgcolor=\"white\">\n");
	/* 1 - Agenda */
	$cabecalho = "  <br /><br /><h5>".Linguas::RetornaFraseDaLista($lista_frases, 1);
	/* 25 - area restrita ao formador. */
	$cabecalho .= " - ".Linguas::RetornaFraseDaLista($lista_frases, 25)."</h5>";
	echo($cabecalho);
	echo("    <br />\n");
	echo("  </body>\n");
	echo("</html>\n");
	AcessoSQL::Desconectar($sock);
	exit();
}
else
{
	echo("    <script type=\"text/javascript\">\n");
	echo("      function Iniciar(){\n");
	echo("        startList();\n");
	echo("        this.focus();\n");
	echo("      }\n");
	echo("    </script>\n");
	echo("  </head>\n");
	echo("  <body link=\"#0000ff\" vlink=\"#0000ff\" onLoad=\"Iniciar();\">\n");

	/* P�gina Principal */

	/* 1 - Agenda */
	$cabecalho = ("<br /><br /><h4>".Linguas::RetornaFraseDaLista ($lista_frases, 1));
	/*43 - Em edicao */
	$cabecalho.= (" - ".Linguas::RetornaFraseDaLista($lista_frases,43)."</h4>\n");
	echo($cabecalho);

	echo ("<br />\n");

	$linha_item=Agenda::RetornaDadosDoItem($sock, $cod_item);

	echo("    <table cellpadding=\"0\" cellspacing=\"0\" id=\"tabelaExterna\" class=\"tabExterna\">\n");
	echo("      <tr>\n");
	echo("        <td valign=\"top\" colspan=3>\n");
	echo("          <ul class=\"btAuxTabs\">\n");
	/* 13 - Fechar (ger) */
	echo("            <li><span onclick=\"self.close();\">".Linguas::RetornaFraseDaLista($lista_frases_geral,13)."</span></li>\n");
	/* 52 - Atualizar (ger) */
	echo("            <li><a href=\"".$view_agenda."em_edicao.php?cod_curso=".$cod_curso."&amp;cod_item=".$cod_item."&amp;origem=".$origem."\">".Linguas::RetornaFraseDaLista($lista_frases_geral,52)."</a></li>\n");
	echo("          </ul>\n");
	echo("        </td>\n");
	echo("      </tr>\n");
	echo("      <tr>\n");
	echo("        <td colspan=3>\n");
	echo("          <table cellpadding=\"0\" cellspacing=\"0\" class=\"tabInterna\">\n");
	echo("            <tr>\n");
	echo("              <td  align=right><b>".Linguas::RetornaFraseDaLista($lista_frases,18).":&nbsp;</b></td>\n");
	echo("              <td colspan=2>".$linha_item['titulo']."</td>\n");
	echo("            </tr>\n");
	echo("          </table>\n");
	echo("        </td>\n");
	echo("      </tr>\n");
	echo("    </table>\n");
	echo("    <table cellpadding=\"0\" cellspacing=\"0\" id=\"tabelaExterna\" class=\"tabExterna\">\n");
	echo("      <tr>\n");
	echo("        <td>\n");
	echo("          <table cellpadding=\"0\" cellspacing=\"0\" class=\"tabInterna\">\n");
	echo("            <tr>\n");
	/* 53 - Situacao (ger)*/
	echo("              <td align=center><b>".Linguas::RetornaFraseDaLista($lista_frases_geral,53)."</b></td>\n");
	/* 56  - Desde (ger) */
	echo("              <td align=center><b>".Linguas::RetornaFraseDaLista($lista_frases_geral,56)."</b></td>\n");
	/* 57 - Por (ger)*/
	echo("              <td align=center><b>".Linguas::RetornaFraseDaLista($lista_frases_geral,57)."</b></td>\n");
	echo("            </tr>\n");
	echo("            <tr>\n");

	$res=Agenda::RetornaResHistoricoDoItem($sock, $cod_item);
	$num_linhas=AcessoSQL::RetornaNumLinhas($res);

	$linha=AcessoSQL::RetornaLinha($res);
	$num_linhas--;
	$nome_usuario=Usuarios::NomeUsuario($sock, $linha['cod_usuario'], $cod_curso);
	$data=Data::UnixTime2DataHora($linha['data']);

	if ($linha['acao']=="E")
		/* 54 - Em Edicao (ger) */
		echo("              <td align=center>".Linguas::RetornaFraseDaLista($lista_frases_geral,54)."</td>\n");
	else
		/* 55 - Edicao concluida (ger) */
		echo("              <td align=center>".Linguas::RetornaFraseDaLista($lista_frases_geral,55)."</td>\n");

	echo("              <td align=center>".$data."</td>\n");
	echo("              <td align=center>".$nome_usuario."</td>\n");

	echo("          </table>\n");
	echo("        </td>\n");
	echo("      </tr>\n");
	echo("    </table>\n");
	echo("  </body>\n");
	echo("</html>\n");
	AcessoSQL::Desconectar($sock);
}

?>