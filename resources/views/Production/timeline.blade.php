@extends('../../master')
@section('title', 'Producción | CognitivoERP')
@section('Title', 'Planificación')

@section('content')

 <style>
    body, html {
      font-family: arial, sans-serif;
      font-size: 11pt;
    }

    #visualization {
      box-sizing: border-box;
      width: 100%;
      height: 300px;
    }
    
    .vis-item.openwheel  { background-color: #B0E2FF; }
    .vis-item.rally      { background-color: #EAEAEA; }
    .vis-item.motorcycle { background-color: #FA8072; }
    .vis-item.touringcar { background-color: #B4EEB4; }
    .vis-item.endurance  { background-color: #FFFFCC; }
  </style>


<div id="visualization"></div>
<div id="loading">loading...</div>
@stop

@section('pagescripts')

<script>

   $(document).ready(function(){
    
    $.get('/get_timeline',function(result){
    	console.log(result)
    })

   })


    $.ajax({
    url: '/get_timeline',
    success: function (data) {
      // hide the "loading..." message
      document.getElementById('loading').style.display = 'none';

      // DOM element where the Timeline will be attached
      var container = document.getElementById('visualization');

      // Create a DataSet (allows two way data-binding)
      //console.log(data)
      var groups= new vis.DataSet(data.production_line)
      var items = new vis.DataSet(data.production_order);
     
      
       var min = new Date(data.range_date[0].mini)
       var max = new Date(data.range_date[0].maxi)

       min.setYear(min.getFullYear() -1);
       max.setYear(max.getFullYear() + 1);
       
      // Configuration for the Timeline
      var options = {
    // option groupOrder can be a property name or a sort function
    // the sort function must compare two groups and return a value
    //     > 0 when a > b
    //     < 0 when a < b
    //       0 when a == b
    groupOrder: function (a, b) {
      return a.value - b.value;
    },
    groupOrderSwap: function (a, b, groups) {
    	var v = a.value;
    	a.value = b.value;
    	b.value = v;
    },

    orientation: 'both',
    editable: true,
    groupEditable: true,
   
     margin: {
      item: 10, // minimal margin between items
      axis: 5   // minimal margin between items and the axis
    },

    onAdd: function (item, callback) {

    	var p=prompt('Add item', 'Enter text content for new item:')

    	if(p){
             item.content = p;
             var end_date = new Date(item.start)            
             item.end = new Date(end_date.setHours(end_date.getHours() +1))
             
             $.ajax({
             	url: '/store_timeline',
             	data:{'content': item.content,'start': item.start,'end':item.end,'group':item.group},
             	success: function(result){
                 item.id = result.id
                 
                  callback(item);
             	},
             	error: function (err) {
      
      if (err.status === 0) {
        alert('Failed to update data.');
      }
      else {
        alert('Failed to update data.');
      }
    }
        
             })

          
    	}else{
    		 callback(null); // cancel item creation
    	}
    
      
    },

     onMove: function (item, callback) {
      

          var r = confirm("Move Item!");
    if (r == true) {
            $.ajax({
           	url: '/update_timeline/'+item.id,
           	data: {'content': item.content,'start': item.start,'end':item.end,'group':item.group},
           	success: function(result){
              item.id = result.id
              callback(item);
           	},
           	error: function (err) {
      
      if (err.status === 0) {
        alert('Failed to update data.');
      }
      else {
        alert('Failed to update data.');
      }
    }
           })

          
    } else {
        callback(null); // cancel editing item
    }

    
    },
    
    onMoving: function(item,callback){
      if (item.start < min) item.start = min;
      if (item.start > max) item.start = max;
      if (item.end   > max) item.end   = max;
      
      callback(item);
    }, 

    onUpdate: function (item, callback) {
    item.content = prompt('Edit items text:', item.content);
    if (item.content != null) {
      callback(item); // send back adjusted item
    }
    else {
      callback(null); // cancel updating the item
    }
  },

   onRemove: function (item, callback) {
   	var r = confirm('Remove item', 'Do you really want to remove item ');    
        if (r) {
           
           $.ajax({
           	url:'/delete_item/'+item.id,
           	   	success: function(result){
             	   
                 if(result != "true"){

                  alert("no se puede elimar")
                  callback(null)
                 }else{

                  callback(item); // confirm deletion
                 }        	
             	},
           		error: function (err) {
      
				    if (err.status === 0) {
				        alert('Failed to update data.');
				    }
				    else {
				        alert('Failed to update data.');
				    }
				}

           })

          
        }
        else {
          callback(null); // cancel deletion
        }
    
    }



  };

      // Create a Timeline
     var timeline = new vis.Timeline(container);
  timeline.setOptions(options);
  timeline.setGroups(groups);
  timeline.setItems(items);
    },
    error: function (err) {
    
      if (err.status === 0) {
        alert('Failed to load data.');
      }
      else {
        alert('Failed to load data.');
      }
    }
  });



  // http://motocal.com/
  /*var groups = new vis.DataSet([
	{"content": "Formula E", "id": "Formula E", "value": 1, className:'openwheel'},
	{"content": "WRC", "id": "WRC", "value": 2, className:'rally'},
	{"content": "MotoGP", "id": "MotoGP", "value": 3, className:'motorcycle'},

  ]);
  
  // create a dataset with items
  // note that months are zero-based in the JavaScript Date object, so month 3 is April
  var items = new vis.DataSet([
	{start: new Date(2015, 0, 10), end: new Date(2015, 0, 11), group:"Formula E", className:"openwheel", content:"Argentina",id:"531@motocal.net"},
	{start: new Date(2015, 0, 22), end: new Date(2015, 0, 26), group:"WRC", className:"rally", content:"Rallye Monte-Carlo",id:"591@motocal.net"},
	{start: new Date(2015, 1, 4), end: new Date(2015, 1, 8), group:"MotoGP", className:"motorcycle", content:"Sepang MotoGP Test 1",id:"578@motocal.net"},
  ])

 
  // create visualization
  var container = document.getElementById('visualization');
  var options = {
    // option groupOrder can be a property name or a sort function
    // the sort function must compare two groups and return a value
    //     > 0 when a > b
    //     < 0 when a < b
    //       0 when a == b
    groupOrder: function (a, b) {
      return a.value - b.value;
    },
    groupOrderSwap: function (a, b, groups) {
    	var v = a.value;
    	a.value = b.value;
    	b.value = v;
    },

    orientation: 'both',
    editable: true,
    groupEditable: true,
    start: new Date(2015, 6, 1),
    end: new Date(2015, 10, 1),
    
    onUpdate: function (item, callback) {
    item.content = prompt('Edit items text:', item.content);
    if (item.content != null) {
      callback(item); // send back adjusted item
    }
    else {
      callback(null); // cancel updating the item
    }
  }

  };

  var timeline = new vis.Timeline(container);
  timeline.setOptions(options);
  timeline.setGroups(groups);
  timeline.setItems(items);*/


</script>
@stop