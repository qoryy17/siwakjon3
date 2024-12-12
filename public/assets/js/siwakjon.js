// [ Zero Configuration ] start
$("#simpletable").DataTable();

// [ Default Ordering ] start
$("#order-table").DataTable({
    order: [[3, "desc"]],
});

document.addEventListener("DOMContentLoaded", function () {
    var genericExamples = document.querySelectorAll("[data-trigger]");
    for (i = 0; i < genericExamples.length; ++i) {
        var element = genericExamples[i];
        new Choices(element, {
            placeholderValue: "Pilih Opsi",
            searchPlaceholderValue: "Pilih Opsi",
        });
    }
});

(function () {
    new SimpleMDE({
        element: document.querySelector("#pc_demo1"),
    });

    const d_week = new Datepicker(document.querySelector("#releaseDate"), {
        buttonClass: "btn",
    });
})();
