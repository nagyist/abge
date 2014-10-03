@extends("backend.layout")

@section("css")
{{HTML::style("assetsadmin/css/bootstrap-fileupload.min.css")}}
{{HTML::style("assetsadmin/css/bootstrap-timepicker.min.css")}}

@stop


@section("js")

{{HTML::script("assetsadmin/js/jquery.jgrowl.js")}}
{{HTML::script("assetsadmin/js/jquery.alerts.js")}}
{{HTML::script("assetsadmin/js/jquery.dataTables.min.js")}}


<script type='text/javascript'>

     jQuery(document).ready(function(){
        // dynamic table
        jQuery.alerts.okButton = '{{Lang::get("display.ok")}}';
        jQuery.alerts.cancelButton = '{{Lang::get("display.cancel")}}';

        jQuery('#dyntable').dataTable({
            "oLanguage": {
                "sProcessing":     "{{ Lang::get('display.processing')}}",
                "sSearch":         "{{ Lang::get('display.search')}}&nbsp;:",
                "sLengthMenu":     "{{ Lang::get('display.show_entries')}}",
                "sInfo":           "{{ Lang::get('display.showing_to_of_entries')}}",
                "sInfoEmpty":      "{{ Lang::get('display.showing_0_to_0_of_0_entries')}}",
                "sInfoFiltered":   "{{ Lang::get('display.filtered_from_total_entries)')}}",
                "sInfoPostFix":    "",
                "sLoadingRecords": "{{ Lang::get('display.loading')}}",
                "sZeroRecords":    "{{ Lang::get('display.no_matching_records_found')}}",
                "sEmptyTable":     "{{ Lang::get('display.no_data_available_in_table')}}",
                "oPaginate": {
                    "sFirst":      "{{ Lang::get('display.first')}}",
                    "sPrevious":   "{{ Lang::get('display.previous')}}",
                    "sNext":       "{{ Lang::get('display.next')}}",
                    "sLast":       "{{ Lang::get('display.last')}}"
                }
            },
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            },
        });


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
					window.location.assign("/dashboard/categories/"+elem.attr("data-action")+"/"+elem.attr("data-id"));
				}
			});
		});
	}
        
    });
</script>
@stop

@section("title")
{{ Lang::get('titles.courses') }}
@stop

@section("iconpage")
<span class="iconfa-tags"></span>
@stop

@section("maintitle")
{{ Lang::get('titles.categories') }}
@stop

@section("nameview")
    {{ Lang::get('display.all_categories') }}
@stop

@section("MainContent")
<div class="maincontent">
            <div class="maincontentinner">
            
                <!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
                @if($msg_success!=null)
						<div class="widgetbox box-success">
                            <h4 class="widgettitle">{{ Lang::get('display.success') }} <a class="close">×</a> <a class="minimize">–</a></h4>
                            <div class="widgetcontent">
                                {{$msg_success}}
                            </div>
                        </div>
                @endif
                <!-- @if(isset($msg_error)) -->
                @if($msg_error!=null)
						<div class="widgetbox box-danger">
                            <h4 class="widgettitle">{{ Lang::get('display.error') }} <a class="close">×</a> <a class="minimize">–</a></h4>
                            <div class="widgetcontent">
                                {{$msg_error}}
                            </div>
                        </div>
                @endif
                <!-- @endif -->
                <div class="widgetbox">
                    <div class="headtitle">
                        <div class="btn-group">
                            <a href="categories/create" class="btn dropdown-toggle">{{ Lang::get('display.add_category')}}</a>
                        </div>
                        <h4 class="widgettitle">{{ Lang::get('display.all_categories') }}</h4>
                    </div>

                    
                    <table id="dyntable" class="table table-bordered responsive">
                        
                        <thead>
                            <tr>
                                <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                                <th class="head0" style="text-align:center;width:10%">{{ Lang::get('display.title') }}</th>
                                <th class="head1" style="text-align:center;width:60%">{{ Lang::get('display.description') }}</th>
                                <th class="head1" style="text-align:center;width;10%">{{ Lang::get('display.status') }}</th>
                                <th class="head0" style="text-align:center;width:20%">{{ Lang::get('display.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($categories as $category)
                            <tr class="gradeX">
                              <td class="aligncenter"><span class="center">
                                <input type="checkbox" />
                              </span></td>
                                <td><h4>{{$category->title}}</h4></td>
                                <td class="description">{{$category->content}}</td>
                                <td>{{ Lang::get('display.'.$category->status.'ed') }}</td>
                                <td class="center">

                                    <a href="/dashboard/categories/update/{{$category->id}}" class="btn btn-warning alertwarning" style="color:#FFF !important;"><i class="iconfa-edit" style="color:#FFF;margin-right:10px;"></i>{{Lang::get('display.edit')}}</a>
                                   
                                    @if($category->status == 'publish')

                                        <a data-id="{{$category->id}}" data-action="draft" class="btn confirmbutton btn-primary alertdanger" style="color:#FFF !important; margin-left:10px;"><i class="iconfa-file" style="color:#FFF;margin-right:10px;"></i>{{ Lang::get('display.draft') }}</a>
                                    
                                    @else
                                    
                                        <a data-id="{{$category->id}}" data-action="publish" class="btn confirmbutton btn-success alertdanger" style="color:#FFF !important; margin-left:10px;"><i class="iconfa-ok" style="color:#FFF;margin-right:10px;"></i>{{ Lang::get('display.publish') }}</a>
                                        <a data-id="{{$category->id}}" data-action="trash" class="btn confirmbutton btn-danger alertdanger" style="color:#FFF !important; margin-left:10px;"><i class="iconfa-trash" style="color:#FFF;margin-right:10px;"></i>{{ Lang::get('display.trash') }}</a>

                                    @endif


                               </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                
@stop