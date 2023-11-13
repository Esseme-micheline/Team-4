function editPresence(id) {
    $.get('/Admin/PresenceSeance/edit/' + id, function(presences) {
        document.getElementById('id').value = presences.presence.id
        document.getElementById('noms').innerHTML = presences.noms
        if (presences.presence.status == 1) {

            document.getElementById('status').checked = true
        } else {
            document.getElementById('status').checked = false
        }
        document.getElementById('status').value = presences.presence.status
        $("#editPresenceModal").modal('toggle');
    })
}
$("#editPresenceForm").submit(function(e) {
    e.preventDefault()
    let id = $("#id").val();
    if (document.getElementById('status').checked == false) {
        document.getElementById('status').value = 0
    } else {
        document.getElementById('status').value = 1
    }
    let status = $("#status").val()

    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/PresenceSeance/update",
        data: {
            id: id,
            status: status,
            _token: _token
        },
        success: function(response) {
            if (response.status == 1) {
                $('#sid' + response.id + ' td:nth-child(4)').text('Present')
            } else {
                $('#sid' + response.id + ' td:nth-child(4)').text('Absent')
            }
            $('#editPresenceModal').modal('toggle')
            $('#editPresenceForm')[0].reset()

        }
    });
})
