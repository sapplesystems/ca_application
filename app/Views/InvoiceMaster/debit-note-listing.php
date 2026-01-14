
<div class="invoiceM-containerr">
    <div class="invoiceM-toolbar">
        <div class="invoiceM-toolbar-title">List Of Generated Debit Note for <?php echo  $client['legal_name']?></div>
        
    </div>

    <div class="invoiceM-table-container">
        <div class="invoiceM-table-wrapper">
            <table class="invoiceM-table">
                <thead>
                    <tr>
                        <th class="invoiceM-sno">Sr No</th>
                        <th style="width:20%;">Debit Note No</th>
                        <th>Client Name</th>
                        <th>Company Name</th>
                        <th>Date</th>
                        <th>TotalAmount</th>
                        <th>Amount Received</th>
                        <th class="invoiceM-actions">Action</th>
                    </tr>
                </thead>


                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($debits as $debit): ?>
                    <tr>
                        <td class="invoiceM-sno"><?= $i++ ?></td>
                        <td class="invoiceM-client-name">
                            <?= esc($debit['debit_no']) ?>
                        </td>
                        <td><?= $debit['legal_name'] ?></td>
                        <td><?= $debit['company_name'] ?></td>
                        <td> <?= esc($debit['date']) ?></td>
                        <td> <?= esc($debit['total_amount']) ?></td>
                        <td><?= esc($debit['advance_amount']) ?></td>
                       <td class="action">
                            <!-- Edit -->
                            <a href="<?= base_url('debits/edit/' . $debit['id']) ?>"
                            class="edit-btn"
                            title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <!-- Delete -->
                            <button type="button"
                                    class="delete-btn"
                                    title="Delete"
                                    data-id="<?= $debit['id'] ?>">
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

    document.addEventListener('click', function (e) {
    if (e.target.closest('.delete-btn')) {
        const id = e.target.closest('.delete-btn').dataset.id;

        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = "<?= base_url('debits/delete/') ?>" + id;
        }
    }
});
</script>