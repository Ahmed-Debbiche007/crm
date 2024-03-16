const modalContent = `
<div class="modal fade" id="pwaModal" tabindex="-1" aria-labelledby="pwaModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">CRM</h5>
      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        X
      </button>
    </div>
    <div class="modal-body">
        <p>Vous pouvez ajouter cette application à votre écran d'accueil pour une utilisation hors ligne.</p>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="downloadPwa" data-bs-dismiss="modal" >Ajouter</button>
    </div>
  </div>
</div>
</div>
`;

let deferredPrompt;

window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
});

function showModal() {
    if (window.matchMedia("(display-mode: standalone)").matches) {
        console.log("Hurray!")
    } else {
        $(document).ready(function () {
            $("body").append(modalContent);
            var newReminderDate = new Date().getTime();
            let oldDate = localStorage.getItem("reminderDate");
            if (
                oldDate == null ||
                newReminderDate - parseInt(oldDate) >= 604800000
            ) {
                setTimeout(() => {
                    $("#pwaModal").modal("show");
                    $("#downloadPwa").click(installApp);
                    $("#pwaModal").on("hidden.bs.modal", function () {
                        localStorage.setItem("reminderDate", newReminderDate);
                    });
                }, 3000);
            }
        });
    }
}

function installApp() {
    if (deferredPrompt) {
        deferredPrompt.prompt();
        deferredPrompt = null;
    }
}
showModal();
