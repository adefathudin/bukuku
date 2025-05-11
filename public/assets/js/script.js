function reloadDataTable(e) {
    $('#' + e).DataTable().ajax.reload();
}

function openModal(e) {
    document.getElementById(e).classList.remove('hidden');
}

function closeModal(e) {
    document.getElementById(e).classList.add('hidden');
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

async function showSweetAlert(type, title, text, icon, yes, no) {
    if (type == 'success') {
        return Swal.fire({
            position: "top-end",
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 1500
        });
    } else if (type == 'error') {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 1500
        });
    } else if (type == 'warning') {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 1500
        });
    } else if (type == 'info') {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 1500
        });
    } else if (type == 'question') {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: false,
            timer: 1500
        });
    } else if (type == 'dialog') {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: yes,
            cancelButtonText: no
        });
    }
}