<script>
    var animateModalTips = document.getElementById('animateModalTips');
    animateModalTips.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var recipient = 'fade-in-scale';
        var modalTitle = animateModalTips.querySelector('.modal-title');
        // modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModalTips.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
            document.body.classList.add('anim-' + recipient);
        }
    });
    animateModalTips.addEventListener('hidden.bs.modal', function(event) {
        removeClassByPrefix(animateModalTips, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
    });

    var animateModalLaporan = document.getElementById('animateModalLaporan');
    animateModalLaporan.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var recipient = button.getAttribute('data-pc-animate');
        var modalTitle = animateModalLaporan.querySelector('.modal-title');
        // modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModalLaporan.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
            document.body.classList.add('anim-' + recipient);
        }
    });
    animateModalLaporan.addEventListener('hidden.bs.modal', function(event) {
        removeClassByPrefix(animateModalLaporan, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
    });

    var animateModalKesimpulan = document.getElementById('animateModalKesimpulan');
    animateModalKesimpulan.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var recipient = button.getAttribute('data-pc-animate');
        var modalTitle = animateModalKesimpulan.querySelector('.modal-title');
        // modalTitle.textContent = 'Animate Modal : ' + recipient;
        animateModalKesimpulan.classList.add('anim-' + recipient);
        if (recipient == 'let-me-in' || recipient == 'make-way' || recipient == 'slip-from-top') {
            document.body.classList.add('anim-' + recipient);
        }
    });
    animateModalKesimpulan.addEventListener('hidden.bs.modal', function(event) {
        removeClassByPrefix(animateModalKesimpulan, 'anim-');
        removeClassByPrefix(document.body, 'anim-');
    });

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
</script>
