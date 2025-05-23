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
    if (document.querySelector("#pc_demo1")) {
        new SimpleMDE({
            element: document.querySelector("#pc_demo1"),
        });
    }
    if (document.querySelector("#releaseDate")) {
        const d_week = new Datepicker(document.querySelector("#releaseDate"), {
            buttonClass: "btn",
        });
    }
})();
