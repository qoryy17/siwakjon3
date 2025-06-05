<script>
    // Date picker
    document.querySelector("#jamSelesai").flatpickr({
        enableTime: true,
        noCalendar: true,
    });

    window.onload = function() {
        let today = new Date();
        // Cek jika hari ini setelah 20 Juni 2025
        let cutoffDate = new Date(2025, 5, 20); // bulan 5 = Juni (0-based)
        if (today > cutoffDate) {
            // Jangan tampilkan modal jika sudah lewat 20 Juni 2025
            return;
        } else {
            let modal = new bootstrap.Modal(document.getElementById("modalAINotula"), {
                keyboard: false,
            });
            modal.show();
        }
    };

    // Simpan instance CKEditor untuk catatan dan kesimpulan
    let catatanEditorInstance, kesimpulanEditorInstance;
    ClassicEditor.create(document.querySelector("#catatan"), {
            toolbar: {
                items: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "link",
                    "bulletedList",
                    "numberedList",
                    "blockQuote",
                    "|",
                    "insertTable",
                    "|",
                    "mediaEmbed",
                    "undo",
                    "redo",
                ],
            },
            removePlugins: [
                "ImageUpload",
                "EasyImage",
                "CKFinderUploadAdapter",
                "CKFinder",
            ],
        })
        .then((editor) => {
            catatanEditorInstance = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    ClassicEditor.create(document.querySelector("#kesimpulan"), {
            toolbar: {
                items: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "link",
                    "bulletedList",
                    "numberedList",
                    "blockQuote",
                    "|",
                    "insertTable",
                    "|",
                    "mediaEmbed",
                    "undo",
                    "redo",
                ],
            },
            removePlugins: [
                "ImageUpload",
                "EasyImage",
                "CKFinderUploadAdapter",
                "CKFinder",
            ],
        })
        .then((editor) => {
            kesimpulanEditorInstance = editor;
        })
        .catch((error) => {
            console.error(error);
        });

    function requestResponAICatatan(param) {
        let reqResponCatatan = document.getElementById("reqResponCatatan");
        let editorInstance, type, btnContent;
        if (param !== "catatan") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Parameter tidak valid !",
            });
            return;
        }
        editorInstance = catatanEditorInstance;

        if (reqResponCatatan) {
            // Set notification on button processing
            reqResponCatatan.textContent = "Meminta respon AI, Mohon tunggu...";
            reqResponCatatan.disabled = true;
        }

        if (!editorInstance) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Editor belum siap !",
            });
            return;
        }

        let content = editorInstance.getData();
        if (!content || content.trim() === "") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Catatan rapat tidak boleh kosong !",
            });
            return;
        }

        $.ajax({
            url: "{{ route('rapat.ai-model-response') }}",
            type: "POST",
            data: {
                content: content,
                type: 'catatanRapat',
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data.response) {
                    editorInstance.setData(data.response);
                    if (reqResponCatatan) {
                        // Set notification on button processing
                        reqResponCatatan.textContent = "Kamu dapat menggunakan AI lagi dalam 1 menit";
                        reqResponCatatan.disabled = true;
                        reqResponCatatan.classList.remove("btn-info");
                        reqResponCatatan.classList.add("btn-danger");
                        setTimeout(function() {
                            reqResponCatatan.disabled = false;
                            reqResponCatatan.textContent = "Sempurnakan Catatan Dengan AI";
                            reqResponCatatan.classList.remove("btn-danger");
                            reqResponCatatan.classList.add("btn-info");
                        }, 60000); // 1 menit = 60000 ms
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Response",
                        text: "Tidak ada respon dari AI",
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Response",
                    text: "Error: " + xhr.statusText,
                });
            },
        });
    }

    function requestResponAIKesimpulan(param) {
        let reqResponKesimpulan = document.getElementById("reqResponKesimpulan");
        let editorInstance, type, btnContent;
        if (param !== "kesimpulan") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Parameter tidak valid !",
            });
            return;
        }
        editorInstance = kesimpulanEditorInstance;

        if (reqResponKesimpulan) {
            // Set notification on button processing
            reqResponKesimpulan.textContent = "Meminta respon AI, Mohon tunggu...";
            reqResponKesimpulan.disabled = true;
        }

        if (!editorInstance) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Editor belum siap",
            });
            return;
        }

        let content = editorInstance.getData();
        if (!content || content.trim() === "") {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Kesimpulan rapat tidak boleh kosong",
            });
            return;
        }

        $.ajax({
            url: "{{ route('rapat.ai-model-response') }}",
            type: "POST",
            data: {
                content: content,
                type: 'kesimpulanRapat',
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                if (data.response) {
                    editorInstance.setData(data.response);
                    if (reqResponKesimpulan) {
                        // Set notification on button processing
                        reqResponKesimpulan.textContent = "Kamu dapat menggunakan AI lagi dalam 1 menit";
                        reqResponKesimpulan.disabled = true;
                        reqResponKesimpulan.classList.remove("btn-info");
                        reqResponKesimpulan.classList.add("btn-danger");
                        setTimeout(function() {
                            reqResponKesimpulan.disabled = false;
                            reqResponKesimpulan.textContent = 'Sempurnakan Kesimpulan Dengan AI';
                            reqResponKesimpulan.classList.remove("btn-danger");
                            reqResponKesimpulan.classList.add("btn-info");
                        }, 60000); // 1 menit = 60000 ms
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Response",
                        text: "Tidak ada respon dari AI",
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Response",
                    text: "Error: " + xhr.statusText,
                });
            },
        });
    }
</script>
