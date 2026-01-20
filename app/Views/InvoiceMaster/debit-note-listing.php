<div class="invoiceM-containerr">
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">List Of Generated Debit Note for <?php echo  $client['legal_name']?></div>

    </div>

    <div class="invoiceM-table-container">
        <div class="invoiceM-table-wrapper">
            <table class="invoiceM-table">
                <thead>
                    <tr>
                        <th class=" invoiceM-sno" style="width:5%;">Sr No</th>
                        <th style="width:10%;">Debit Note No /Credit Note No.</th>
                        <th style="width:10%;">Client Name</th>
                        <th style="width:15%;">Company Name</th>
                        <th style="width:10%;">Note Type</th>
                        <th style="width:10%;">Date</th>
                        <th style="width:10%;">TotalAmount</th>
                        <th style="width:10%;">Amount Received</th>
                        <th class="invoiceM-actions" style="width:10%;">Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($debits as $debit): ?>
                    <tr>
                        <td class="invoiceM-sno"><?= $i++ ?></td>
                        <td class="invoiceM-client-name">
                            <?= esc(
        $debit['note_type'] === 'debit'
            ? $debit['debit_no']
            : $debit['credit_no']
    ); ?>
                        </td>
                        <td><?= $debit['legal_name'] ?></td>
                        <td><?= $debit['company_name'] ?></td>
                        <td><?= ucfirst(esc($debit['note_type'])) ?></td>
                        <td> <?= esc($debit['date']) ?></td>
                        <td> <?= esc($debit['total_amount']) ?></td>
                        <td><?= esc($debit['advance_amount']) ?></td>
                        <td class="action">
                            <!-- Edit -->
                            <a href="<?= base_url('debits/edit/' . $debit['id']) ?>" class="edit-btn" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <!-- Delete -->
                            <button type="button" class="delete-btn" title="Delete" data-id="<?= $debit['id'] ?>">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                        <?php endforeach; ?>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-btn')) {
        const id = e.target.closest('.delete-btn').dataset.id;

        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = "<?= base_url('debits/delete/') ?>" + id;
        }
    }
});
</script>