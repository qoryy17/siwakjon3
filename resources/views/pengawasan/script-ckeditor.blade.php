<script>
    (function() {
        ClassicEditor.create(document.querySelector('#dasarHukum'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#deskripsiPengawasan'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#kesimpulan'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'alignment', '|', // tambahkan ini untuk perataan text
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder'],
            alignment: {
                options: ['left', 'center', 'right', 'justify']
            }
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#rekomendasi'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        // for form add temuan
        ClassicEditor.create(document.querySelector('#judul'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#kondisi'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#kriteria'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#sebab'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#akibat'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

        ClassicEditor.create(document.querySelector('#rekomendasi1'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', '|', 'mediaEmbed',
                    'undo', 'redo'
                ]
            },
            removePlugins: ['ImageUpload', 'EasyImage', 'CKFinderUploadAdapter', 'CKFinder']
        }).catch((error) => {
            console.error(error);
        });

    })();
</script>
