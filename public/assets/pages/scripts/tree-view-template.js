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

function load_tree(id) {
    console.log(id)
    $('#jstree').jstree({
        'core': {
            'check_callback': true,
            'data': {
                "url": "/load_tree/" + id,
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
        console.log(fulltree)
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
        //alert($('#type_load').val())
        load_tree($('#type_load').val())
    }
});
$("#add_task").on("click", function() {
    var node_select = $('#jstree').jstree('get_selected')[0]
    var name_node = $('#item').val() + "\t" + $('#unit_value').val()
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
        url: '/project_template/' + sel[0],
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
    var text = $('#item').val() + "\t" + $('#unit_value').val()
    var id_item = $('#id_item').val()
    $('#jstree').jstree('rename_node', sel, text);
    ref.get_node(sel[0]).data.id_item = id_item;
};

function items() {
    var options = {
        url: function(phrase) {
            var frase = $("#item").val();
            var type_item = $("#type_item").val();
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
function load_tree_project_order(id) {
    var tree = $("#jstree").jstree(true);
    if (tree != false) {
        $("#jstree").jstree("destroy");
    }
    $('#jstree').jstree({
        'core': {
            'check_callback': true,
            'data': {
                "url": "/load_tree/" + id,
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
    }).on('rename_node.jstree', function(e, data) {

        var token = $("#update_task_production_order").data('token');
        var ref = $('#jstree').jstree(true)
            sel = ref.get_selected();

        $.ajax({
                url: '/project_template/' + sel[0],
                type: 'post',
                data: {
                    _method: 'put',
                    _token: token,
                    'text': data.text,
                    'production_order': 1
                },
                success: function(msg) {
             
                },
                error: function(msg) {}
            })
            /* $.get('response.php?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
               .fail(function () {
                 data.instance.refresh();
               });*/
    }).jstree();
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
                $('#name_contact').text(name_contact).trigger("change");
                 $('#name_parent').text(name_parent).trigger("change");
                $("#id_contact").val(value).trigger("change");
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