var isFetchingUE = false
function afficheUE(niv_id, fil_id) {
    let affiche_ue = document.getElementById('affiche_ue' + niv_id + '_' + fil_id);
    if (affiche_ue.innerHTML != "") {
        affiche_ue.innerHTML = "";
    } else {
        if (!isFetchingUE) {
            isFetchingUE = true
            $.get("/Inscription/TDs/" + niv_id + '/' + fil_id,
                function (data, textStatus, jqXHR) {
                    // console.log(data);
                    $.each(data, function (key, value) {
                        if(value.tds.length>0){
                            if (value.tds[0].groupe_tds.length > 0) {
                                $('#affiche_ue' + niv_id + '_' + fil_id).append('\
                                <li><a href="/Inscription/GroupeTd/'+ value.id + '">' + value.code + ' - ' + value.intitule + '</a>\
                                </li>');
                            }
                        }
                    });
                    isFetchingUE = false
                }
            );
        }
    }
}
var isFetchingNiveau = false
function afficheNiv(id) {

    let espace_chang = document.getElementById('espace_chang' + id)
    if (espace_chang.innerHTML != "") {
        espace_chang.innerHTML = ""

    } else {
        if (!isFetchingNiveau) {
            isFetchingNiveau = true
            $.get("/Inscription/Niveau",
                function (data, textStatus, jqXHR) {
                    $.each(data, function (key, value) {
                        $('#espace_chang' + id).append('\
                            <li><a href="javascript:void(0)" onclick="handleFetchingUE(' + value.id + ', ' + id + ')">' + value.intitule + '</a>\
                            <div><ul id="affiche_ue'+ value.id + '_' + id + '"></ul></div></li>');
                    });
                    isFetchingNiveau = false

                }
            );
        }

    }

}
function handleFetchingUE(niv_id, fil_id) {
    if (!isFetchingUE) {
        afficheUE(niv_id, fil_id)
    }
}
function handleFetchingNiv(fil_id) {
    if (!isFetchingNiveau) {
        afficheNiv(fil_id)
    }
}
