<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi CKEditor untuk setiap field edit temuan
        let judulEdit, kondisiEdit, kriteriaEdit, sebabEdit, akibatEdit, rekomendasiEdit;

        ClassicEditor.create(document.querySelector('#judulEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            judulEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#kondisiEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            kondisiEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#kriteriaEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            kriteriaEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#sebabEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            sebabEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#akibatEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            akibatEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#rekomendasiEdit'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).then(editor => {
            rekomendasiEdit = editor;
        }).catch(error => {
            console.error(error);
        });

        const editButtons = document.querySelectorAll('.edit-temuan');
        const editModal = new bootstrap.Modal(document.getElementById('animateModalTemuanEdit'));

        editButtons.forEach(button => {
            button.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');
                const judul = this.getAttribute('data-judul');
                const kondisi = this.getAttribute('data-kondisi');
                const kriteria = this.getAttribute('data-kriteria');
                const sebab = this.getAttribute('data-sebab');
                const akibat = this.getAttribute('data-akibat');
                const rekomendasi = this.getAttribute('data-rekomendasi');
                const waktuPenyelesaian = this.getAttribute('data-waktuPenyelesaian');

                document.getElementById('idTemuan').value = id;
                document.getElementById('waktuPenyelesaianEdit').value = waktuPenyelesaian;

                // Tunggu semua editor siap sebelum set data
                // Karena inisialisasi editor async, pastikan sudah siap
                function waitForEditor(editorVar, cb) {
                    if (editorVar) {
                        cb();
                    } else {
                        setTimeout(() => waitForEditor(editorVar, cb), 50);
                    }
                }

                waitForEditor(judulEdit, () => judulEdit.setData(judul || ''));
                waitForEditor(kondisiEdit, () => kondisiEdit.setData(kondisi || ''));
                waitForEditor(kriteriaEdit, () => kriteriaEdit.setData(kriteria || ''));
                waitForEditor(sebabEdit, () => sebabEdit.setData(sebab || ''));
                waitForEditor(akibatEdit, () => akibatEdit.setData(akibat || ''));
                waitForEditor(rekomendasiEdit, () => rekomendasiEdit.setData(rekomendasi ||
                    ''));

                editModal.show();
            });
        });
    });
</script>
