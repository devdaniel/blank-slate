if (!Array.prototype.forEach) {
    Array.prototype.forEach = function (fn, scope) {
        'use strict';
        var i, len;
        for (i = 0, len = this.length; i < len; ++i) {
            if (i in this) {
                fn.call(scope, this[i], i, this);
            }
        }
    };
}

Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator, currencySymbol) {
    // check the args and supply defaults:
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces;
    decSeparator = decSeparator == undefined ? "." : decSeparator;
    thouSeparator = thouSeparator == undefined ? "," : thouSeparator;
    currencySymbol = currencySymbol == undefined ? "$" : currencySymbol;

    var n = this,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;

    return sign + currencySymbol + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

Date.prototype.yyyymmdd = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
    var dd = this.getDate().toString();
    return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
};

$.datepicker.setDefaults({
    "dateFormat": "yy-mm-dd"
});

$('.date_picker').datepicker();

function toTitleCase(str) {
    return str.replace(
            /\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
    );
}

function showAlert(target, type, subject, message) {
    target.find('.alert').hide("slow");
    target.append('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'+subject+'</strong> '+message+'</div>');
}

function form_object(selector) {
    var inputs = $(selector).find('input[name],select[name],input[type=checkbox],textarea[name]');
    var fields = {};

    for(i = 0; i < inputs.length; i++) {
        var fieldname = $(inputs[i]).attr('name');
        var is_array = false;
        if(fieldname.slice(-2) == "[]") {
            fieldname = fieldname.substring(0, fieldname.length - 2);
            is_array = true;
        }
        if($(inputs[i]).attr('type') == 'checkbox') {
            if(is_array) {
                if(fields[fieldname] instanceof Array) {
                    fields[fieldname].push($(inputs[i]).is(':checked'));
                } else {
                    fields[fieldname] = Array($(inputs[i]).is(':checked'));
                }
            } else {
                fields[fieldname] = $(inputs[i]).is(':checked');
            }
        } else {
            if(is_array) {
                if(fields[fieldname] instanceof Array) {
                    fields[fieldname].push($(inputs[i]).val());
                } else {
                    fields[fieldname] = Array($(inputs[i]).val());
                }
            } else {
                fields[fieldname] = $(inputs[i]).val();
            }
        }
    }

    return fields;
}

function form_reset(selector) {
    // Inputs
    var inputs = $(selector).find('input[name],select[name]');
    for(i = 0; i < inputs.length; i++) {
        $(inputs[i]).val('');
    }
    // Dropdowns
    inputs = $(selector).find('select');
    for(i = 0; i < inputs.length; i++) {
        $(inputs[i]).get(0).selectedIndex = 0;
    }
}

function querystring_object() {
    var querystrings = location.search.slice(1).split('&')
    var queries = {};

    for(var i = 0; i < querystrings.length; i++) {
        var k = decodeURI(querystrings[i].split('=')[0]);
        var v = decodeURI(querystrings[i].split('=')[1]);

        // Check if array
        if(k.substring(k.length-2,k.length) == '[]') {
            k = k.slice(0,-2); // Remove '[]' from key name
            if(typeof(queries[k]) == 'undefined') {
                queries[k] = [v];
            } else if(typeof(queries[k]) == 'object') {
                queries[k].push(v);
            }
        } else {
            queries[k] = v;
        }
    }

    return queries;
}
