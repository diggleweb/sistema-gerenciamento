<?php
session_start("login");

require_once("_script/UsuarioDAO.php");
require_once("_script/CategoriaDAO.php");


    /* Testa se a variável de sessão está setada corretamente
     * Caso contrário, gera erro acusando que o login não foi feito */
    if( !isset($_SESSION["nome_usuario_logado"]) )
    	header('Location: index.php?ERRO=2');


    /* Pega variável de página "page"
     * Não deixa usuário normal acessar aquelas páginas que só admin podem */
    if( isset($_GET["page"]) ){
        if( $_SESSION["permissao_usuario_logado"] == 1 )
            $menu = $_GET["page"];
        elseif( ($_SESSION["permissao_usuario_logado"] == 0) && ($_GET["page"] != "UsuariosCadastrar") )
                $menu = $_GET["page"];
}

?>





<!DOCTYPE html>
<html lan="pt-br">
<head>
	<title>Sistema de Gerenciamento</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8"/>
	<meta name="generator" content="Jair Junior" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="_style/css/mystyle.css">
	<link rel="stylesheet" type="text/css" href="_style/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>




<body>
<!-- **************************************************************************************************** -->
<!-- ***************************************** MENU SUPERIOR FIXO *************************************** -->
<!-- **************************************************************************************************** -->
<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="console.php">Sistema de Gerenciamento</a>
        </div>

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                    	<span class="glyphicon glyphicon-user"></span>&nbsp;
                    	<?php echo $_SESSION["nome_usuario_logado"]." ".$_SESSION["sobrenome_usuario_logado"]; ?>
                    	<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="usuario_listagem.php"><i class="glyphicon glyphicon-asterisk"></i>&nbsp;&nbsp; Alterar Senha</a></li>
                        <li class="divider"></li>
                        <li><a href="_script/Logout.php"><i class="glyphicon glyphicon-log-out"></i>&nbsp;&nbsp; Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    	<!-- /navbar --> 
    </div>
    <!-- /container-fluid -->
</div>
<!-- /Header -->



<!-- **************************************************************************************************** -->
<!-- ***************************************** PARTE PRINCIPAL ****************************************** -->
<!-- **************************************************************************************************** -->
<div class="container-fluid">
    <div class="row">
        <!-- ************************************************************************ -->
        <!-- ********************** MENU LATERAL ESQUERDO *************************** -->
        <!-- ************************************************************************ -->
        <div class="col-sm-3" id="sideBar">
            

            <!-- *********************************************** -->
            <!-- ****** INÍCIO DOS MENUS DE GERENCIAMENTO ****** -->
            <!-- *********************************************** -->
            <span id="menu-title"><span class="glyphicon glyphicon-briefcase"></span> Gerenciamento</span>
            <hr>

            <ul class="nav nav-stacked">


                <!-- Menu Vendas -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuVendas">
                    <span class="glyphicon glyphicon-usd"></span>
                    <strong>Vendas</strong>
                    <i class="glyphicon glyphicon-chevron-down"></i></a>
                    
                        <ul class="nav nav-stacked collapse" id="menuVendas">
                            <li><a href="#"><i class="glyphicon glyphicon-plus-sign"></i> Registrar Venda</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-object-align-right"></i> Estoque</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Histórico de Vendas</a></li>
                        </ul>
                </li>


                <!-- Menu Compras -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuCompras">
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    <strong>Compras</strong>
                    <i class="glyphicon glyphicon-chevron-down"></i></a>

                        <ul class="nav nav-stacked collapse" id="menuCompras">
                            <li><a href="#"><i class="glyphicon glyphicon-plus-sign"></i> Registrar Compra</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-time"></i> Compras a Receber</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i> Histórico de Compras</a></li>
                        </ul>
                </li>
                

                <!-- Menu Fluxo de Caixa -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuFluxo">
                    <span class="glyphicon glyphicon-piggy-bank"></span>
                    <strong>Fluxo de Caixa</strong>
                    <i class="glyphicon glyphicon-chevron-down"></i></a>
                    
                        <ul class="nav nav-stacked collapse" id="menuFluxo">
                            <li><a href="#"><i class="glyphicon glyphicon-plus-sign"></i> Registrar Movimento</a></li>
                            <li><a href="#"><i class="glyphicon glyphicon-th-list"></i> Consultar</a></li>
                        </ul>
                </li>


                <!-- Menu Estatísticas -->
                <li class="nav-header"><a href="#" data-toggle="collapse">
                    <span class="glyphicon glyphicon-stats"></span> <strong>Estatísticas</strong> </a>
                </li>
            </ul>
            <hr>
            <!-- FIM DOS MENUS DE GERENCIAMENTO -->



            <!-- *********************************************** -->
            <!-- ****** INÍCIO DOS MENUS DE CONFIGURAÇÕES ****** -->
            <!-- *********************************************** -->
            <span id="menu-title"><i class="glyphicon glyphicon-wrench"></i> Configurações</span>
            <hr>

            <ul class="nav nav-stacked">


                <!-- Menu Produtos -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuProdutos">
                    <span class="glyphicon glyphicon-barcode"></span> 
                    <strong>Produtos</strong> 
                    <?php if( ($menu=='ProdutosConsultar') || ($menu=='ProdutosCadastrar') || ($menu=='ProdutosCategorias') ){ ?>
                        <i class="glyphicon glyphicon-chevron-up"></i></a> <?php
                        $menuAberto = "in";
                    }else{ ?>
                        <i class="glyphicon glyphicon-chevron-down"></i></a>
                    <?php } ?>
                        
                        <ul class="nav nav-stacked collapse <?php if(isset($menuAberto)){echo $menuAberto; $menuAberto = '';}?>" id="menuProdutos">
                            <li><a href="#"><i class="glyphicon glyphicon-search"></i> Consultar</a></li>
                            <!-- Só mostra link de Cadastrar e Categorias se o usuário for Admin -->
                            <?php if( $_SESSION['permissao_usuario_logado'] == 1 ){  ?>
                                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Cadastrar</a></li>
                                <li><a href="?page=ProdutosCategorias"><i class="glyphicon glyphicon-tags"></i> &nbsp;Categorias</a></li>
                            <?php } ?>
                        </ul>
                </li>


                <!-- Menu Clientes -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuClientes">
                    <span class="glyphicon glyphicon-user"></span> 
                    <strong>Clientes</strong> 
                    <i class="glyphicon glyphicon-chevron-down"></i></a>
                        
                        <ul class="nav nav-stacked collapse" id="menuClientes">
                            <li><a href="#"><i class="glyphicon glyphicon-search"></i> Consultar</a></li>
                            <!-- Só mostra link de Cadastrar se o usuário for Admin -->
                            <?php if( $_SESSION['permissao_usuario_logado'] == 1 ){  ?>
                                <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Cadastrar</a></li>
                            <?php } ?>
                        </ul>
                </li>


                <!-- Menu Usuários -->
                <li class="nav-header"><a href="#" data-toggle="collapse" data-target="#menuUsuario">
                    <span class="glyphicon glyphicon-screenshot"></span> 
                    <strong>Usuários</strong>
                    <?php if( ($menu=='UsuariosConsultar') || ($menu=='UsuariosCadastrar') ){ ?>
                        <i class="glyphicon glyphicon-chevron-up"></i></a> <?php
                        $menuAberto = "in";
                    }else{ ?>
                        <i class="glyphicon glyphicon-chevron-down"></i></a>
                    <?php } ?>
                        
                        <ul class="nav nav-stacked collapse <?php if(isset($menuAberto)){echo $menuAberto; $menuAberto = '';}?>" id="menuUsuario">
                            <li><a href="?page=UsuariosConsultar"><i class="glyphicon glyphicon-search"></i> Consultar</a></li>
                            <!-- Só mostra link de Cadastrar se o usuário for Admin -->
                            <?php if( $_SESSION['permissao_usuario_logado'] == 1 ){  ?>
                                <li><a href="?page=UsuariosCadastrar"><i class="glyphicon glyphicon-cog"></i> Cadastrar</a></li>
                            <?php } ?>
                    </ul>
                </li>
            </ul>
            <!-- FIM DOS MENUS DE CONFIGURAÇÕES -->

        </div>
        <!-- FIM DO MENU LATERAL ESQUERDO -->


        <!-- ************************************************************************ -->
        <!-- ******************** CORPO DA PÁGINA (CONTEÚDO) ************************ -->
        <!-- ************************************************************************ -->
        <div class="col-sm-9">

           <?php
                switch ($menu)
                {
                    case "ProdutosCategorias":
                        include('_paginas/categorias.php');
                        break;
                    case "UsuariosConsultar":
                        include('_paginas/usuario_listagem.php');
                        break;
                    case "UsuariosCadastrar":
                        include('_paginas/usuario_cadastrar.php');
                        break;
                    default:
                        include('_paginas/dashboard.php');
                }
           ?>

        </div>
        <!-- FIM DO CORPO DA PÁGINA (CONTEÚDO) -->


    </div>
    <!-- /row -->
</div>
<!-- /container-fluid -->




<script type="text/javascript" src="_style/js/bootstrap.min.js"></script>
<script type="text/javascript" src="_style/js/scripts.js"></script>
</body>
</html>