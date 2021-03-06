@extends("backend.layout")

@section("css")
{{HTML::style("assetsadmin/css/bootstrap-fileupload.min.css")}}
{{HTML::style("assetsadmin/css/bootstrap-timepicker.min.css")}}

@stop


@section("js")


<?php 

    function paginatorURI( $filter ){
        return '';
       /* return "&nombre_completo=". ($filter['nombre_completo'] != '' ? $filter['nombre_completo'] : '0') ."&categoria=". ($filter['categoria'] != '' ? $filter['categoria'] : '0') ."&tipo_pessoa=".( $filter['tipo_pessoa'] != '' ? $filter['tipo_pessoa'] : '0') ."&pagamento=".( $filter['pagamento'] != '' ? $filter['pagamento'] : '0') ."";*/
    }

?>

{{HTML::script("assetsadmin/js/jquery.jgrowl.js")}}
{{HTML::script("assetsadmin/js/jquery.alerts.js")}}
{{HTML::script("assetsadmin/js/jquery.dataTables.min.js")}}

<script type='text/javascript'>

    var confirmButtons = function(){
        
        if(jQuery('.confirmbutton').length > 0) {
          jQuery('.confirmbutton').on("click",function(e){
            e.preventDefault();
            var elem=jQuery(this);
            var action = null;
            switch(elem.attr("data-action")){
                case 'publish':
                    action = '{{Lang::get("messages.publish")}}';
                    break;
                case 'draft':
                    action = '{{Lang::get("messages.draft")}}';
                    break;
                case 'trash':
                    action = '{{Lang::get("messages.trash")}}';
                    break;
                case 'delete':
                    action = '{{Lang::get("messages.delete")}}';
                    break;
                default:
                    action = '{{Lang::get("messages.draft")}}';
                    break;
            }
            jConfirm('{{ Lang::get("messages.are_you_sure") }} '+action+' {{ Lang::get("messages.this_element") }}', '{{ Lang::get("display.confirmation_dialog")}}', function(r) {
                 // jAlert('Confirmed: ' + r, 'Confirmation Results');
                if(r==true){
                    console.log("{{ $route }}/"+elem.attr("data-action")+"/"+elem.attr("data-id"));
                    window.location.assign("{{ $route }}/"+elem.attr("data-action")+"/"+elem.attr("data-id"));
                    }
                });
            });
        }

    }

     jQuery(document).ready(function(){
        // dynamic table

        /*var table = jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });*/

        confirmButtons();

        table.on('page.dt', function(e){
            console.log("page");
            confirmButtons();
        });

        table.on('draw.dt', function(e){
            console.log("draw");
            confirmButtons();
        });
        
    });
</script>
@stop

@section("title")
Newsletters
@stop

@section("iconpage")
<span class="iconfa-book"></span>
@stop

@section("maintitle")
Newsletters
@stop

@section("nameview")
    Todas as Newsletters
@stop

@section("MainContent")
<div class="maincontent">
            <div class="maincontentinner">
            
                <!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
                <div class="widgetbox">
                    <div class="headtitle">
                        <div class="btn-group">
                            <a href="{{ $route }}/create" class="btn dropdown-toggle">Adicionar Newsletter</a>
                        </div>
                        <h4 class="widgettitle">Newsletters</h4>
                    </div>
                    <table id="dyntable" class="table table-bordered responsive">
                        <colgroup>
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="head0 nosort" style="width:15%"><input type="checkbox" class="checkall" /></th>
                                <th class="head0" width="30%">Nome</th>
                                <th class="head1"style="width:25%">Email</th>
                                <th class="head0" style="width:45%">{{ Lang::get('display.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($newsletters))
                                @foreach($newsletters as $newsletter)
                                    <tr class="gradeX">
                                      <td class="aligncenter"><span class="center">
                                        <input type="checkbox" />
                                      </span></td>
                                        <td>{{$newsletter->name}}</td>
                                        <td>{{$newsletter->email}}</td>
                                        <td class="center">
                                            <a href="{{ $route }}/update/{{$newsletter->id}}" class="btn btn-warning alertwarning" style="color:#FFF !important;"><i class="iconfa-edit" style="color:#FFF;margin-right:10px;"></i>{{Lang::get('display.edit')}}</a>
                                            <a data-id="{{$newsletter->id}}" data-action="delete" class="btn confirmbutton btn-danger alertdanger" style="color:#FFF !important;"><i class="iconfa-trash" style="color:#FFF;margin-right:10px;"></i>{{Lang::get('display.delete')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination">

                        <ul class="pagination"> 
                            <li>
                                <a href="{{$route}}?page=1{{paginatorURI( $filter )}}">Primera</a>
                            </li>
                            <li {{ $newsletters->getCurrentPage() == 1 ? 'class=disabled': '' }}>
                                @if($newsletters->getCurrentPage() == 1)
                                    <span>Anterior</span>
                                @else
                                    <a href="{{$route}}?page={{ $newsletters->getCurrentPage() -1 }}{{paginatorURI( $filter )}}">Anterior</a>
                                @endif
                            </li>
                            @if($newsletters->getCurrentPage() > 8)
                                <li>
                                    <a href="{{$route}}?page=1{{paginatorURI( $filter )}}">1</a>
                                </li>
                                <li {{ $newsletters->getCurrentPage() == 1 ? 'class=disabled': '' }}>
                                    <a href="{{$route}}?page=2{{paginatorURI( $filter )}}">2</a>
                                </li>
                                <li class="disabled"><span>...</span></li>
                            @endif
                            @for($i = $newsletters->getCurrentPage() - 3 ; $i <= ($newsletters->getCurrentPage() + 3) ; $i++)
                                @if($i > 0 && $i <= $newsletters->getLastPage())
                                    @if($i == $newsletters->getCurrentPage())
                                        <li class="active">
                                            <span>{{($i)}}</span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{$route}}?page={{($i)}}{{paginatorURI( $filter )}}">{{($i)}}</a>
                                        </li>
                                    @endif
                                @endif
                            @endfor
                            @if($newsletters->getCurrentPage() < ($newsletters->getLastPage() - 5))
                                <li class="disabled"><span>...</span></li>
                                <li>
                                    <a href="{{$route}}?page={{($newsletters->getLastPage() - 1)}}{{paginatorURI( $filter )}}">{{($newsletters->getLastPage() - 1)}}</a>
                                </li>
                                <li >
                                    <a href="{{$route}}?page={{($newsletters->getLastPage())}}{{paginatorURI( $filter )}}">{{($newsletters->getLastPage() )}}</a>
                                </li>
                            @endif
                            <li {{ $newsletters->getCurrentPage() == 1 ? 'class=disabled': '' }}>
                                @if($newsletters->getCurrentPage() == $newsletters->getLastPage())
                                    <span>Siguiente</span>
                                @else
                                    <a href="{{$route}}?page={{$newsletters->getCurrentPage() + 1}}{{paginatorURI( $filter )}}">Siguiente</a>
                                @endif
                            </li>
                            <li>
                                <a href="{{$route}}?page={{ $newsletters->getLastPage() }}{{paginatorURI( $filter )}}">Última</a>
                            </li>
                        </ul>   
                        
                        <!--{{ $newsletters->links() }}-->
                        
                    </div>
                </div>
                
                    <style type="text/css">
                        .pagination ul{
                            list-style: none;
                            display: inline-block;
                        }
                        .pagination{
                            text-align: right;
                        }
                    </style>

                
@stop