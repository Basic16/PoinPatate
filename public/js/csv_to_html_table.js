
    var varietes = [];
    var couleurs =[];
    var entetes =[];
    var couleur = "";
    var request= $.ajax({
    url: "http://serveur1.arras-sio.com/symfony4-4066/PoinPatate/public/api/varietes",
    method: "GET",
    dataType: "json",
    beforeSend: function( xhr ) {
       xhr.overrideMimeType( "application/json; charset=utf-8" );
    }});
    request.done(function( msg ) {
       $.each(msg, function(index,e){
       varietes.push(e.nom) ;
       couleurs.push(e.couleur) ;
       });
    });
    // Fonction qui se lance lorsque l’accès au web service provoque une erreur
    request.fail(function( jqXHR, textStatus ) {
    alert ('erreur');
    });





var CsvToHtmlTable = CsvToHtmlTable || {};


CsvToHtmlTable = {
    init: function (options) {
        options = options || {};
        var csv_path = options.csv_path || "";
        var el = options.element || "table-container";
        var allow_download = options.allow_download || false;
        var csv_options = options.csv_options || {};
        var datatables_options = options.datatables_options || {};
        var custom_formatting = options.custom_formatting || [];
        var customTemplates = {};
        $.each(custom_formatting, function (i, v) {
            var colIdx = v[0];
            var func = v[1];
            customTemplates[colIdx] = func;
        });

        var $table = $("<table class='table table-striped table-condensed' id='" + el + "-table'></table>");
        var $containerElement = $("#" + el);
        $containerElement.empty().append($table);

        $.when($.get(csv_path)).then(
            function (data) {
                var csvData = $.csv.toArrays(data, csv_options);
                var $tableHead = $("<thead></thead>");
                var csvHeaderRow = csvData[0];
                var $tableHeadRow = $("<tr></tr>");
                for (var headerIdx = 0; headerIdx < csvHeaderRow.length; headerIdx++) {
                    entetes.push(csvHeaderRow[headerIdx].replace(/ /g,""));
                    if((headerIdx % 4) != 0){
                    $tableHeadRow.append($("<th  class='"+ entetes[Math.floor(headerIdx/4)*4] +"' style=' display: none;'></th>").text(csvHeaderRow[headerIdx]));}
                    else{$tableHeadRow.append($("<th onClick=toggle('"+ entetes[headerIdx]+"')></th>").text(csvHeaderRow[headerIdx]));}
                }
                $tableHead.append($tableHeadRow);

                $table.append($tableHead);
                var $tableBody = $("<tbody></tbody>");

                for (var rowIdx = 1; rowIdx < csvData.length; rowIdx++) {
                    var $tableBodyRow = $("<tr></tr>");
                    for (var colIdx = 0; colIdx < csvData[rowIdx].length; colIdx++) {
                        for (var i = 0; i < varietes.length; i++) {
                            
                            if(csvData[rowIdx][colIdx] ==  varietes[i]){
                                 couleur = couleurs[i];
                                 break;
                           }
                           else{
                                couleur = "";}
                          }
                          if(colIdx%4 != 0){
                            var $tableBodyRowTd = $("<td contenteditable='true'" + "value='" + csvData[rowIdx][colIdx] + "' style='background-color:"+ couleur +"; display: none;' class='"+ entetes[Math.floor(colIdx/4)*4] +"'></td>");
                          }                                                                                                                                                    
                          else{
                            var $tableBodyRowTd = $("<td data-toggle='modal' data-target='#exampleModalCenter' onClick=variete('"+ rowIdx + '-' + colIdx+"')  id='"+ rowIdx + '-' + colIdx +"'" + "value='" + csvData[rowIdx][colIdx] + "' style='background-color:"+ couleur +"' class=''></td>");
                          }
                        
                        var cellTemplateFunc = customTemplates[colIdx];
                        if (cellTemplateFunc) {
                            $tableBodyRowTd.html(cellTemplateFunc(csvData[rowIdx][colIdx]));
                            
                        } else {
                            $tableBodyRowTd.text(csvData[rowIdx][colIdx]);
                            
                        }
                        $tableBodyRow.append($tableBodyRowTd);
                        $tableBody.append($tableBodyRow);
                    }
                }
                $table.append($tableBody);

                $table.DataTable(datatables_options);

                if (allow_download) {
                    $containerElement.append("<p><a class='btn btn-info' href='" + csv_path + "'><i class='glyphicon glyphicon-download'></i> Download as CSV</a></p>");
                }
            });
    }
};
