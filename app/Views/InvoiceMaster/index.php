<!-- Modal -->
<div class="modal fade" id="debitpopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="debitP">
                    <div class="header">Generate Debit Note</div>

                    <div class="content">
                        <div class="title">Choose Company For Invoice</div>

                        <div class="radio-box">
                            <label>
                                <input type="radio" name="company_debitP" />
                                Deleted SAMPURN [Consultancy Master]
                            </label>

                            <label>
                                <input type="radio" name="company_debitP" />
                                ENDLESS SOLUTIONS [Consultancy Master]
                            </label>

                            <label>
                                <input type="radio" name="company_debitP" />
                                Meenakshi Company [Charted Account Master]
                            </label>

                            <label>
                                <input type="radio" name="company_debitP" />
                                OXFYNN SERVICES PRIVATE LIMITED [Charted Account Master]
                            </label>
                        </div>

                        <div class="buttons">
                            <button class="btn btn-proceed">Proceed</button>
                            <button class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="invoiceM-containerr">
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">Client Grid</div>
        <div class="invoiceM-toolbar-actions">
            <input type="text" class="invoiceM-search-input" placeholder="Search Client Name..." />
            <button class="invoiceM-btn invoiceM-btn-search">Search</button>
            <button class="invoiceM-btn invoiceM-btn-reset">Reset</button>
        </div>
    </div>

    <div class="invoiceM-table-container">
        <div class="invoiceM-table-wrapper">
            <table class="invoiceM-table">
                <thead>
                    <tr>
                        <th class="invoiceM-sno">Sr No</th>
                        <th>Client Name</th>
                        <th class="invoiceM-actions">Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($clients as $client): ?>
                    <tr>
                        <td class="invoiceM-sno"><?= $i++ ?></td>
                        <td class="invoiceM-client-name">
                            <?= esc($client['legal_name']) ?>
                        </td>


                        <td>
                            <div class="invoiceM-action-group">
                                <!-- <button class="invoiceM-action-btn invoiceM-btn-manage">
                                    💼 Manage Invoice
                                </button> -->
                                <a href="<?= base_url('ManageInvoice/') ?><?= $client['id'] ?>"
                                    class="invoiceM-action-btn invoiceM-btn-manage">
                                    💼 Manage Invoice
                                </a>

                                <!-- <button class="invoiceM-action-btn invoiceM-btn-generate">
                                    📄 Generate Debit
                                </button> -->
                                <a href="#" class="invoiceM-action-btn invoiceM-btn-manage" data-toggle="modal"
                                    data-target="#debitpopup">
                                    📄 Generate Debit
                                </a>
                                <button class="invoiceM-action-btn invoiceM-btn-list">
                                    📋 Debit Note List
                                </button>
                            </div>
                        </td>
                        <?php endforeach; ?>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document
    .querySelector(".invoiceM-search-input")
    .addEventListener("input", function(e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll(".invoiceM-table tbody tr");
        rows.forEach((row) => {
            const name = row
                .querySelector(".invoiceM-client-name")
                .textContent.toLowerCase();
            row.style.display = name.includes(term) ? "" : "none";
        });
    });

document
    .querySelector(".invoiceM-btn-reset")
    .addEventListener("click", function() {
        document.querySelector(".invoiceM-search-input").value = "";
        document
            .querySelectorAll(".invoiceM-table tbody tr")
            .forEach((row) => (row.style.display = ""));
    });

document.querySelectorAll(".invoiceM-action-btn").forEach((btn) => {
    btn.addEventListener("click", function() {
        const client = this.closest("tr").querySelector(
            ".invoiceM-client-name"
        ).textContent;
        console.log(`${this.textContent} clicked for ${client}`);
    });
});
</script>