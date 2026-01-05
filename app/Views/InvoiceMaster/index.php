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
                                <button class="invoiceM-action-btn invoiceM-btn-manage">
                                    💼 Manage Invoice
                                </button>
                                <button class="invoiceM-action-btn invoiceM-btn-generate">
                                    📄 Generate Debit
                                </button>
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