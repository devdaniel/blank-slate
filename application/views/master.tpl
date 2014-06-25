<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--[if lt IE 9]>
            <script src="{$js['html5shiv']}"></script>
        <![endif]-->
        <!--[if IE 7]>
            <link rel="stylesheet" href="{$css['font-awesome-ie7']}">
        <![endif]-->

        <title>{block name="title"}{/block} - Website</title>

        <link rel="stylesheet" href="{$css['bootstrap']}" />
        <link rel="stylesheet" href="{$css['bootstrap-responsive']}" />
        <link rel="stylesheet" href="{$css['bootstrap-select']}" />
        <link rel="stylesheet" href="{$css['font-awesome']}" />
        <link rel="stylesheet" href="{$css['jqueryui']}" />
        <link rel="stylesheet" href="{$css['main']}" />

        <script src="{$js['jquery']}"></script>
        {block name='cssjs_files'}{/block}
        <style type="text/css">
            /* TV/Monitor Adjustments */
            {if ($output == 'tv')}
                .navbar, footer {
                    display: none;
                }
                .feedback {
                    display: none;
                }
                body {
                    background: #fff !important;
                }
            {else}
                body {
                    padding-bottom: 55px;
                    /*padding-top: 60px;*/
                }
            {/if}
        {block name='css'}{/block}
        </style>
    </head>
    <body>
        {include file="navbar.htm"}
        <div class="container">
{if $show_intro}
    {block name="intro"}{/block}
{/if}
{block name="content"}{/block}
            {if $output != 'tv'}<hr />{/if}
{if isset($queries)}
            <div class="row">
                <pre>
{$queries|print_r}
                </pre>
            </div>
{/if}
            <footer><div id="tips">Website Slogan</div><div class="pull-right">Copyright &copy; <a href="{base_url()}" target="_blank">Corp, Inc.</a> 2014</div></footer>
        </div>
        <script src="{$js['jqueryui']}"></script>
        <script src="{$js['jquery.tablesorter']}"></script>
        <script src="{$js['bootstrap']}"></script>
        <script src="{$js['bootstrap-select']}"></script>
        <script src="{$js['main']}"></script>
        <script lang="javascript">
            // Global Javascript Block
            fix_numbers();
            $('.selectpicker').selectpicker();
            var csrf_token_name = '{$csrf_token['token_name']}';
            var csrf_hash = '{$csrf_token['hash']}';
        </script>
        {block name='js'}{/block}
{literal}
<!-- Google Analytics Here -->
{/literal}
    </body>
</html>
