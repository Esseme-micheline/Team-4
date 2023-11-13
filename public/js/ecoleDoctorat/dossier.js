function ajoutJuryPre(id, valeur) {
    document.getElementById('jury_id').innerHTML = '<option value="">Selectionner un champs</option>'
    $.get("/Ecole_Doctorat/Dossier/jury_P?id=" + id + '&valeur=' + valeur,
        function (data, textStatus, jqXHR) {
            document.getElementById('valeur').value = valeur
            document.getElementById('id').value = id
            $.each(data.data, function (key, item) {
                if (item.id == data.valeur) {
                    $('#jury_id').append(
                        '<option value="' + item.id + '" selected>' + item.noms + '</option>'
                    );
                } else {
                    $('#jury_id').append(
                        '<option value="' + item.id + '">' + item.noms + '</option>'
                    );
                }

            });
        },
    );
    $('#editDossierJuryModal').modal('toggle');
}
function editTheme(id){
    document.getElementById('theme_recherche').innerHTML = ""
    $.get("/Ecole_Doctorat/Dossier/edit/" + id,
        function (data, textStatus, jqXHR) {
            // console.log(data[0]);
            document.getElementById('id_d').value = data[0].id
            document.getElementById('theme_recherche').innerHTML =data[0].theme_recherche

        },
    );
    $('#editDossierThemeModal').modal('toggle');

}
// $('#editDossierJuryForm').submit(function (e) {
//     e.preventDefault();
//     let id = $('#id').val();
//     let valeur = $('#valeur').val();
//     let jury_id = $('#jury_id').val();
//     let _token = $("input[name=_token]").val();
//     console.log(id);
//     $.ajax({
//         type: "GET",
//         url: "/Ecole_Doctorat/Dossier/update",
//         data: {
//             _token: _token,
//             id: id,
//             valeur: valeur,
//             jury_id: jury_id,
//         },
//         success: function (response) {
//             console.log(response.data.encadreur);
//             console.log(response);
//             if (valeur == "encadreur") {
//                 document.getElementById('encadreur' + response.data.id).innerHTML = " "
//                 $('#encadreur' + response.data.id).append('<a class="dropdown-item"\
//                 href="/Ecole_Doctorat/jury/voir/'+ response.data.encadreur.id + '">' + response.data.encadreur.noms + '</a>');

//             } else if (valeur == "coencadreur") {
//                 document.getElementById('coencadreur'+response.data.id).innerHTML=""
//                 $('#coencadreur'+response.data.id).append('<a class="dropdown-item"\
//                 href="/Ecole_Doctorat/jury/voir/'+ response.data.co_encadreur.id + '">' + response.data.co_encadreur.noms + '</a>');

//             } else if (valeur == "cooencadreur") {

//             } else if (valeur == "president_jury") {

//             } else if (valeur == "examinateur") {

//             } else if (valeur == "coexaminateur") {

//             }
//             // document.getElementById(valeur+id).innerHTML=
//             // $('#sid' + response.id + ' td:nth-child(2)').text(response.matricule)
//             // $('#sid' + response.id + ' td:nth-child(3)').text(response.noms)
//             $('#editDossierJuryModal').modal('toggle')
//             $('#editDossierJuryForm')[0].reset()
//         }
//     });

// });
