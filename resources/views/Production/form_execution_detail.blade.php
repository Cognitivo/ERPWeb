@extends('master')
@section('title', 'Execution | CognitivoERP')
@section('Title', 'Execution Form')
@section('content')
<div id="app">
  <div class="portlet light ">
    <div class="portlet-title tabbable-line">
      <div class="caption caption-md">
        <i class="icon-globe theme-font hide"></i>
        <span class="caption-subject font-blue-madison bold uppercase">Ejecuciones</span>
      </div>
    </div>
    <input type="hidden" id="id_order" name="" value="{{$id}}">
    <div class="portlet-body">
      
      <table class="table table-condensed" id="table-production-execution-form">
        <thead>
          <tr>
            <th>Item</th>
            <th>Cantidad Estimada</th>
            <th>Cantidad Real</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal fade" id="modal_detail_execution" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span
          aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Detalle</h4>
        </div>
        <div class="modal-body">
        <div class="row">
          <div class="col-md-3">
             <a class="btn btn-primary"  href="#" v-on:click="addExecutionDetail($event)">Adicionar</a>
          </div>
          <div class="col-md-9">
          <div class="col-md-3">
             <label class="control-label">Cantidad</label>
          </div>
          <div class="col-md-6">
             <input type="number" name="" class="form-control" value="0" style="display: inline;">   
          </div>
           
            
          </div>
         
          
        </div>
                   
          <div class="table-scrollable">
            <table class="table table-hover">
              <thead>
               
                  <th>
                    Item
                  </th>
                  <th>
                    Cantidad
                  </th>
                  <th>
                    Acciones
                  </th>
               
              </thead>
              <tbody >
              
                <tr v-for="(detail,index) in detail_execution">
                  <td>@{{detail.name}}</td>
                  <td>@{{detail.quantity}}</td>
                  <td><a href="#" v-on:click="deleteDetail(detail.id,index)" class="btn btn-sm btn-primary">
                <i class="glyphicon glyphicon-remove"></i>
                </a></td>
                </tr>
               
              </tbody>
            </table>
            
          </div>
        </div>
        <div class="modal-footer">
        
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END PAGE CONTENT INNER -->
@endsection
@section('scripts')
<script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/assets/utilities/axios/axios.min.js" type="text/javascript"></script>
<script src="/assets/utilities/vue/vue.js" type="text/javascript"></script>
<script src="/assets/utilities/js/execution_form.js" type="text/javascript"></script>
@endsection