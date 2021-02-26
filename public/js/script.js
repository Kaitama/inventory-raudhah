$(document).ready(function () {
    $(".ui.dropdown").dropdown();
    $(".ui.checkbox").checkbox();
    var datatableLanguage = {
        language: {
            emptyTable: "Data masih kosong.",
            info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data.",
            infoEmpty: "Menampilkan 0 sampai 0 dari total 0 data.",
            infoFiltered: "(memfilter dari _MAX_ total data)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Tampilkan _MENU_ data",
            loadingRecords: "Loading...",
            processing: "Processing...",
            zeroRecords: "Tidak ada data ditemukan.",
            search: "Cari",
            paginate: {
                first: "&rsaquo;&rsaquo;",
                last: "&lsaquo;&lsaquo;",
                next: "&rsaquo;",
                previous: "&lsaquo;",
            },
        },
    };
    $(".datatable").DataTable(datatableLanguage);
    $(".sidebar-menu-toggler").on("click", function () {
        var target = $(this).data("target");
        $(target)
            .sidebar({
                dinPage: true,
                transition: "overlay",
                mobileTransition: "overlay",
            })
            .sidebar("toggle");
    });
});
