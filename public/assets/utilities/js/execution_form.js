 var table;
 var id = $('#id_order').val()
 table = $('#table-production-execution-form').DataTable({
     processing: true,
     serverSide: true,
     responsive: true,
     "pagingType": "bootstrap_full_number",
     "pageLength": 50,
     ajax: {
         url: '/production_execution_table/' + id,
         type: "get",
     },
     "order": []
 }).on('draw.dt', function(e) {
     $('#table-production-execution-form_processing').css('display', 'none')
     new Vue({
         el: '#app',
         data: {
             detail_execution: [],
             current_id_order_detail : null
         },
         methods: {
             loadDataExecutionDetail: function(id_order_detail) {
                 axios.get('/api/execution_detail/' + id_order_detail).then(response => {
                     // JSON responses are automatically parsed.
                     this.detail_execution = response.data,
                     this.current_id_order_detail = id_order_detail
                 }).catch(function(error) {
                     console.log(error);
                 });
             },
             deleteDetail : function(id_execution,index){
             axios.get('/api/execution_detail_delete/' + id_execution).then(response => {
                     // JSON responses are automatically parsed.
                     //this.detail_execution = response.data,
                     //this.current_id_order_detail = id_order_detail
                      this.detail_execution.splice(index, 1);
                 }).catch(function(error) {
                     console.log(error);
                 });
             },
             addExecutionDetail : function(event){

              var element = event.currentTarget;
              var quantity = $(element).parent().parent().find('input').val()

             axios.post('/api/update_execution/' + this.current_id_order_detail, {
                      quantity: quantity,
                     
                    }).then(response => {
                     // JSON responses are automatically parsed.
                     //console.log(response.data.data)
                     this.detail_execution.push(response.data.data)
                 }).catch(function(error) {
                     console.log(error);
                 });
             }
         }
     })
 })