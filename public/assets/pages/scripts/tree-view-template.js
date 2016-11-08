var _selectedNodeId;

function tree_new() {
    $("#jstree").jstree({
        "core": {
            // so that create works
            "check_callback": true
                //"data": data
        },
        "types": {
            "file": {
                "icon": "fa fa-file icon-state-warning",
                "valid_children": []
            }
        },
        "plugins": ["state", "types"]
    }).on("select_node.jstree", function(e, _data) {
        if (_selectedNodeId === _data.node.id) {
            _data.instance.deselect_node(_data.node);
            _selectedNodeId = "";
        } else {
            _selectedNodeId = _data.node.id;
        }
    }).jstree();
}

function load_tree(id_template,id_project) {
    //console.log(id)
    $('#jstree').jstree({
        'core': {
            'check_callback': true,
            'data': {
                "url": "/load_tree/" + id_template + "/" +id_project,
                "dataType": "json"
            },
        },
        "types": {
            "file": {
                "icon": "fa fa-file icon-state-warning",
                "valid_children": []
            }
        },
        "plugins": ["state", "types"]
    }).bind("loaded.jstree", function(event, data) {
        data.instance.open_all();
        var objtree = $('#jstree').jstree(true).get_json('#', {
            flat: true
        })
        var fulltree = JSON.stringify(objtree);
        //console.log(fulltree)
        $('#tree_save').val(fulltree)
    }).on("select_node.jstree", function(e, _data) {
        if (_selectedNodeId === _data.node.id) {
            _data.instance.deselect_node(_data.node);
            _selectedNodeId = "";
        } else {
            _selectedNodeId = _data.node.id;
        }
    }).jstree();
}
$(function() {
    contacts()
    items()



    if ($('#type_load').val() == '#') {
        tree_new()
    } else {
<<<<<<< HEAD
      //  alert($('#type_load').val())
      //  load_tree($('#type_load').val(),null)
=======

        load_tree($('#type_load').val(),null)
>>>>>>> f2ac716bbad346966af20ae3ee26d4bd171ea781
    }

    var parent = $('#parent_name_contact').val()
    var son =$('#contact').val()

   draw_tree_contact(parent,son)

   var lat = $('#geo_lat').val()
   var lng = $('#geo_long').val()
   var address = $('#address_contact').val()

   if(lat!=undefined && lng!=undefined){
    load_gmap_contact(lat,lng,address)
   }



});
$("#add_task").on("click", function() {
    var node_select = $('#jstree').jstree('get_selected')[0]
    var name_node = $('#item').val()
    var type = $('#type_item').val()
    if (node_select == undefined) {
        if (name_node != "") {
            createNode('#', name_node, type)
        }
    } else {
        createNode('#' + node_select, name_node, type)
    }
});

var tree_save = new Object()
var tree_global = []

function createNode(parent, text, type) {
    var id_item = $('#id_item').val()
    if (type == 5) {
        $('#jstree').jstree().create_node(parent, {
            "text": text,
            "data": {
                'id_item': id_item
            }
        }, "last", function() {});
    } else {
        $('#jstree').jstree().create_node(parent, {
            "text": text,
            "type": "file",
            "data": {
                'id_item': id_item
            }
        }, "last", function() {});
    }
    var objtree = $('#jstree').jstree(true).get_json('#', {
        flat: true
    })
    var fulltree = JSON.stringify(objtree);
    $('#tree_save').val(fulltree)
        //console.log(fulltree)
}
$("#remove_task").on('click', function() {
    demo_delete()
})
$("#update_task").on('click', function() {
    demo_rename()
})

function demo_delete() {
    //alert("lk")
    var token = $("#remove_task").data('token');
    var ref = $('#jstree').jstree(true),
        sel = ref.get_selected();
    $.ajax({
        url: '/project_template_detail_destroy/' + sel[0],
        type: 'post',
        data: {
            _method: 'delete',
            _token: token
        },
        success: function(msg) {
            if (!sel.length) {
                return false;
            }
            ref.delete_node(sel);
        },
        error: function(msg) {}
    })
};

function demo_rename() {
  
    var ref = $('#jstree').jstree(true),
        sel = ref.get_selected();
    var text = $('#item').val()
    var id_item = $('#id_item').val()
    $('#jstree').jstree('rename_node', sel, text);
    ref.get_node(sel[0]).data.id_item = id_item;
};

function items() {
    var options = {
        url: function(phrase) {
            var frase = $("#item").val();
            var type_item = $("#type_item option:selected").val();
            return "/get_item/" + type_item + "/?query=" + frase;
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
    $("#item").easyAutocomplete(options);
}
/*  $('document').bind("click", function (e) {
        if(!$(e.target).parents("#jstree:eq(0)").length) {
               $('#jstree').jstree().deselect_all();
        }
      }); */
//Production Order
var aux_id=null
function load_tree_project_order(id_template,id_project) {
    //console.log("loko")
    //
    var tree = $("#jstree").jstree(true);
    if(aux_id!=id_template){
    if (tree != false) {
        $("#jstree").jstree("destroy");
    }
    aux_id=id_template


    $('#jstree').jstree({
        'core': {
            'check_callback': true,
            'data': {
                "url": "/load_tree/" + id_template + "/" +id_project,
                "dataType": "json",
                "data": {'id_production_order': $('#id_production_order').val()}
            },
        },
        "types": {
            "file": {
                "icon": "fa fa-file icon-state-warning",
                "valid_children": []
            }
        },
        "plugins": ["state", "types"]
    }).bind("loaded.jstree", function(event, data) {
        data.instance.open_all();
        var objtree = $('#jstree').jstree(true).get_json('#', {
            flat: true
        })
        var fulltree = JSON.stringify(objtree);
        //console.log(fulltree)
        $('#tree_save').val(fulltree)
    }).on("select_node.jstree", function(e, _data) {
        if (_selectedNodeId === _data.node.id) {
            _data.instance.deselect_node(_data.node);
            _selectedNodeId = "";
        } else {
            _selectedNodeId = _data.node.id;
        }
    }).jstree();

  }


    /*on('rename_node.jstree', function(e, data) {
        var token = $("#update_task_production_order").data('token');
        var ref = $('#jstree').jstree(true)
        sel = ref.get_selected();
        $.ajax({
                url: '/save_project_task_production_order/' + sel[0],
                type: 'post',
                data: {
                    _method: 'post',
                    _token: token,
                    'text': data.text,
                    'id_project': id,
                    ''
                },
                success: function(msg) {},
                error: function(msg) {}
            })

    })*/
}

function demo_rename_production_order() {
    var ref = $('#jstree').jstree(true),
        sel = ref.get_selected();
    if (!sel.length) {
        return false;
    }
    sel = sel[0];
    ref.edit(sel);

};
$('#update_task_production_order').click(function() {
    demo_rename_production_order()
})

function contacts() {

    var options = {
        url: function(phrase) {
            var frase = $("#contact").val();
            return "/all_contacts/?query=" + frase;
        },
        getValue: function(element) {
            return element.name
        },
        list: {
            onSelectItemEvent: function() {
                var value = $("#contact").getSelectedItemData().id_contact;
                var name_contact = $("#contact").getSelectedItemData().name;
                var name_parent = $('#contact').getSelectedItemData().parent_name;
                var lat = $("#contact").getSelectedItemData().geo_lat;
                var lng = $("#contact").getSelectedItemData().geo_long;
                var address = $("#contact").getSelectedItemData().address;
                draw_tree_contact(name_parent, name_contact)
                $("#id_contact").val(value).trigger("change");

                load_gmap_contact(lat,lng,address)

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
            data.phrase = $("#contact").val();
            return data;
        },
        requestDelay: 500
            //theme: "square"
    };
    $("#contact").easyAutocomplete(options);
}

function draw_tree_contact(parent, son) {
    var tree = $("#tree_1").jstree(true);
    if (tree != false) {
        $("#tree_1").jstree("destroy");
    }
    $('#tree_1').jstree({
        'core': {
            'data': [{
                'text': parent,
                'state': {
                    'opened': true,
                    'selected': true
                },
                'children': [
                    son
                ]
            }]
        }
    });
};


//get name project
/*$(document).ready(function(){
  var name_project= $('#id_project option:selected').text()
  get_name_project(name_project)
})*/
$('#id_project').on('change', function() {


    var name_project = $('#id_project option:selected').text()
    get_name_project(name_project)
    var id_project_id_project_template = $('#id_project option:selected').val()
    //var id_project_template = id_project_id_project_template.split("-")[1]
    //load_tree_project_order(id_project_template)


})

function get_name_project(name) {
    $('#name_production_order').val(name)
}


function load_gmap_contact(lat,lng,address) {
   $('#address_contact').val(address).trigger('change')
                var map;
                map = new GMaps({
                    div: '#gmap_geo',
                    lat: lat,
                    lng: lng
                });
                /*  map.addMarker({
                      lat: lat,
                      lng: lng,
                      title: 'Lima',
                      details: {
                          database_id: 42,
                          author: 'HPNeo'
                      },
                      click: function(e) {
                          if (console.log) console.log(e);
                          alert('You clicked in this marker');
                      }
                  });*/
                /*               GMaps.geocode({
    lat: lat,
    lng: lng,
    callback: function(results, status) {
        if (status == 'OK') {
          console.log(results[0])
             // results = list of addresses at that location
        }
    }
});*/
                GMaps.geocode({
                    address: address.trim(),
                    callback: function(results, status) {
                        if (status == 'OK') {
                            var latlng = results[0].geometry.location;
                            map.setCenter(latlng.lat(), latlng.lng());
                            map.addMarker({
                                lat: latlng.lat(),
                                lng: latlng.lng()
                            });
                        }
                    }
                });
}
