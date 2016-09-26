@extends('../../master')
@section('title', 'Plantilla | CognitivoERP')
@section('Title', 'Plantilla')

@section('css')
	 <link href="{{ url() }}/assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')



<div class="portlet light ">
	<div class="portlet-title">

	    <div class="actions">
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;"  id="add_task">
	            <i class="icon-cloud-upload"></i>
	        </a>
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="update_task" >
	            <i class="icon-wrench"></i>
	        </a>
	        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" id="remove_task" data-token="{{ csrf_token() }}">
	            <i class="icon-trash"></i>
	        </a>


	    </div>
	</div>
	<div class="row">
		 <div class="portlet-body form">
		 @if (isset($template))
		 	 {{--  <form class="form-horizontal" role="form" method="put" action="{{route('project_template.update',$template) }}"> --}}
		 	 {!! Form::model($template,['route' => ['project_template.update',$template], 'method'=>'put','class'=> 'form-horizontal']) !!}
		 @else
		 	  <form class="form-horizontal" role="form" method="post" action="{{route('project_template.store') }}">
		 @endif


		   {!! csrf_field() !!}

		<div class="col-md-6">
			 <div class="form-body">
	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Tipo de Trabajo
	                    </label>
	                    <div class="col-md-9">
	                      {{--   <input class="form-control" placeholder="Enter text" type="text" name="name"  />     --}}
	                        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Full Name']) !!}
	                    </div>
	                </div>




	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Tipo de Artículo
	                    </label>
	                    <div class="col-md-9">
	                     {!!  Form::select('type_item',['5'=>'Tarea','1'=>'Producto','2'=>'Materia Prima','3'=>'Servicio','4'=>'Activo Fijo','6'=>'Insumo','7'=>'Contrato Servicio'],null,['class'=> 'form-control' ,'id'=>'type_item']) !!}

	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                        Artículo
	                    </label>
	                    <div class="col-md-9">
	                        <div class="input-icon">
	                            <i class="fa fa-bell-o">
	                            </i>
	                            <input class="form-control" placeholder="Left icon" type="text" id="item" name="item" />
	                            <input type="hidden" name="id_item" id="id_item" value="">
	                        </div>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 control-label">
	                       Cantidad
	                    </label>
	                    <div class="col-md-9">
	                         <input class="form-control" value="0" type="text" name="unit_value"  id="unit_value" />
	                    </div>
	                </div>

	            </div>
	            <div class="form-actions">
	                <div class="row">
	                    <div class="col-md-offset-3 col-md-9">
	                        <button class="btn green" type="submit">
	                            Submit
	                        </button>
	                        <button class="btn default" type="button">
	                            Cancel
	                        </button>
	                    </div>
	                </div>
	            </div>
		</div>

		<div class="col-md-6">
			<div class="portlet-title">

	         </div>
	        <div class="portlet-body">
	        @if (isset($template))
	        <input type="hidden" id="type_load" value="{{$template->id_project_template}}">
	                 <div id="jstree" class="tree-demo">

                      </div>
	                  @else
	                    <input type="hidden" id="type_load" value="#">
	                <div id="jstree" class="tree-demo" >

                   </div>
	                  @endif

			</div>
		</div>

		<input type="hidden" name="tree_save" id="tree_save">

	        </form>

	</div>
</div>


</div>
@stop

@section('scripts')
	<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url() }}/assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
     <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ url() }}/assets/pages/scripts/ui-tree.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->


        <script>
        	var _selectedNodeId;

        	function tree_new() {
        		$("#jstree").jstree({
     "core" : {
       // so that create works
       "check_callback" : true

        //"data": data
     },"types" : {
		"file" : { "icon" : "fa fa-file icon-state-warning", "valid_children" : [] }
	},

    "plugins" : ["state", "types"]



  }).on("select_node.jstree", function (e, _data) {
    if ( _selectedNodeId === _data.node.id ) {
        _data.instance.deselect_node(_data.node);
        _selectedNodeId = "";
    } else {
        _selectedNodeId = _data.node.id;
    }
               }).jstree();
      }

     function load_tree(id) {

	$('#jstree').jstree({

    'core': {

        'check_callback': true,
        'data': {
            "url": "/load_tree/"+id,
            "dataType": "json"
        },

    },"types" : {
		"file" : { "icon" : "fa fa-file icon-state-warning", "valid_children" : [] }
	},


    "plugins" : ["state", "types"]
}).bind("loaded.jstree", function(event, data) {

    data.instance.open_all();
     var objtree=$('#jstree').jstree(true).get_json('#',{ flat : true})

      	  var fulltree = JSON.stringify(objtree);

      	   $('#tree_save').val(fulltree)

}).on("select_node.jstree", function (e, _data) {
    if ( _selectedNodeId === _data.node.id ) {
        _data.instance.deselect_node(_data.node);
        _selectedNodeId = "";
    } else {
        _selectedNodeId = _data.node.id;
    }
               }).jstree();
}


      $(function () {
    	items()

      	if($('#type_load').val()=='#'){
      		tree_new()
      	}else{
      		//alert($('#type_load').val())
      		load_tree($('#type_load').val())
      	}
   });

      $("#add_task").on("click",function() {

	console.log($('#jstree').jstree('get_selected')[0])
	var node_select=$('#jstree').jstree('get_selected')[0]
	var name_node= $('#item').val()+"\t"+$('#unit_value').val()
	var type= $('#type_item').val()
     if(node_select==undefined){
     	if(name_node!=""){
     	createNode('#',name_node,type)
     	}
     }else{
       createNode('#'+node_select,name_node,type)

     }

});

      var tree_save= new Object()
      var tree_global = []

      function createNode(parent,text,type){
      var id_item= $('#id_item').val()
      	if(type==5){
          $('#jstree').jstree().create_node(parent ,  {"text" : text,"data":{'id_item':id_item}}, "last", function(){});


      	}else{
      		$('#jstree').jstree().create_node(parent ,  {"text" : text,"type": "file","data":{'id_item':id_item} },"last", function(){});
      	}

      	 var objtree=$('#jstree').jstree(true).get_json('#',{ flat : true})
      	  var fulltree = JSON.stringify(objtree);
      	   $('#tree_save').val(fulltree)
      	  //console.log(fulltree)
      }

      $("#remove_task").on('click',function(){
      	demo_delete()
      })

      $("#update_task").on('click',function(){
      	demo_rename()
      })

      function demo_delete() {
      	//alert("lk")


		var token = $("#remove_task").data('token');
		var ref = $('#jstree').jstree(true),
			sel = ref.get_selected();

    $.ajax({
        url:'/project_template/'+sel[0],
        type: 'post',
        data: {_method: 'delete', _token :token},
        success:function(msg){

		if(!sel.length) { return false; }
		ref.delete_node(sel);
        },
        error: function(msg){

        }

    })


	};


		function demo_rename() {
			var ref = $('#jstree').jstree(true),
				sel = ref.get_selected();

				var text= $('#item').val()+"\t"+$('#unit_value').val()
				var id_item= $('#id_item').val()
		          $('#jstree').jstree('rename_node', sel, text);
		          ref.get_node(sel[0]).data.id_item = id_item;

		};



function items(){

    var options = {

        url: function(phrase) {

            var frase= $("#item").val();
            var type_item = $("#type_item").val();

            return "/get_item/"+type_item+"/?query="+frase;
        },

        getValue: function(element) {

            return element.name
        },
     list: {
            onSelectItemEvent: function() {
            var value = $("#item").getSelectedItemData().id_item;


            $("#id_item").val(value).trigger("change");

           }
        },

        ajaxSettings: {
            dataType: "json",
            method: "get",
            data: {
                dataType: "json"
            }
        },

        ajaxSettings: {
        dataType: "json",
            method: "get",
            data: {
            dataType: "json"
        }
    },

        preparePostData: function(data) {
            data.phrase = $("#item").val();

            return data;


        },

        requestDelay: 500
        //theme: "square"
    };

  //  $("#item").easyAutocomplete(options);
}





    /*  $('document').bind("click", function (e) {
            if(!$(e.target).parents("#jstree:eq(0)").length) {
                   $('#jstree').jstree().deselect_all();
            }
          }); */


        </script>
@stop
