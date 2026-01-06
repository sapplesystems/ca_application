 <!-------------------------------- Modal for genrate invoice------------------------------------->
 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <div class="Gvoice-wrapper">
                     <!-- Title -->
                     <div class="Gvoice-title">Choose Works And Company For Invoice</div>

                     <!-- Invoice type row -->
                     <div class="Gvoice-row">
                         <div class="Gvoice-label">
                             Select Invoice Type: <span class="Gvoice-required">*</span>
                         </div>
                         <select class="Gvoice-select">
                             <option>Automatic Invoice</option>
                             <option>Manual Invoice</option>
                             <!-- other options -->
                         </select>
                     </div>

                     <!-- Choose work section -->
                     <div class="Gvoice-section-title">Choose Work For Invoice</div>
                     <div class="Gvoice-box">
                         <div class="Gvoice-option-row">
                             <input type="checkbox" />
                             <div class="Gvoice-option-text">
                                 PAN Application (25032101 )[Consultancy Fee]
                             </div>
                             <div class="Gvoice-option-status">Allocated</div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="checkbox" />
                             <div class="Gvoice-option-text">
                                 PAN Correction (25032102 )[Consultancy Fee]
                             </div>
                             <div class="Gvoice-option-status">Allocated</div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="checkbox" />
                             <div class="Gvoice-option-text">
                                 MSME Registration (25032103 )[Consultancy Fee]
                             </div>
                             <div class="Gvoice-option-status">Allocated</div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="checkbox" />
                             <div class="Gvoice-option-text">
                                 Consultancy Charges (25032104 )[Consultancy Fee]
                             </div>
                             <div class="Gvoice-option-status">Allocated</div>
                         </div>

                         <!-- aur works yahan add kar sakte ho -->
                     </div>

                     <!-- Choose company section -->
                     <div class="Gvoice-section-title">Choose Company For Invoice</div>
                     <div class="Gvoice-box">
                         <div class="Gvoice-option-row">
                             <input type="radio" name="company" />
                             <div class="Gvoice-option-text">
                                 Deleted SAMPURN [Consultancy Master]
                             </div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="radio" name="company" />
                             <div class="Gvoice-option-text">
                                 ENDLESS SOLUTIONS [Consultancy Master]
                             </div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="radio" name="company" />
                             <div class="Gvoice-option-text">
                                 Meenakshi Company [Charted Account Master]
                             </div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="radio" name="company" />
                             <div class="Gvoice-option-text">
                                 OXYFYN SERVICES PRIVATE LIMITED [Charted Account Master]
                             </div>
                         </div>
                     </div>

                     <!-- Choose tax section -->
                     <div class="Gvoice-section-title">Choose tax For Invoice</div>
                     <div class="Gvoice-box">
                         <div class="Gvoice-option-row">
                             <input type="radio" name="tax" />
                             <div class="Gvoice-option-text">CGST &amp; SGST</div>
                         </div>

                         <div class="Gvoice-option-row">
                             <input type="radio" name="tax" />
                             <div class="Gvoice-option-text">IGST</div>
                         </div>
                     </div>

                     <!-- Buttons -->
                     <div class="Gvoice-actions">
                         <button class="Gvoice-btn Gvoice-btn-success">Proceed</button>
                         <button class="Gvoice-btn Gvoice-btn-danger">Cancel</button>
                     </div>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <div class="Minvoice-wrapper">
     <!-- Header -->
     <div class="Minvoice-header">List Of Generated Invoice for NEROCA</div>

     <!-- Top Buttons -->
     <div class="Minvoice-top-actions">
         <button class="Minvoice-btn Minvoice-btn-primary">Print Ledger</button>
         <button type="button" class=" Minvoice-btn Minvoice-btn-primary" data-toggle="modal"
             data-target="#exampleModal">
             Generate Invoice For Pending Work
         </button>
         <button class="Minvoice-btn Minvoice-btn-primary">
             Back To Client Grid
         </button>
     </div>

     <!-- Filters -->
     <div class="Minvoice-filter-row">
         <div class="Minvoice-filter-group">
             <label for="Minvoice-company">Select Company</label>
             <select id="Minvoice-company">
                 <option>Select Company</option>
             </select>
         </div>

         <div class="Minvoice-filter-group">
             <label for="Minvoice-fromDate">From:</label>
             <input type="date" id="Minvoice-fromDate" />
         </div>

         <div class="Minvoice-filter-group">
             <label for="Minvoice-toDate">To:</label>
             <input type="date" id="Minvoice-toDate" />
         </div>

         <div class="Minvoice-filter-buttons">
             <button class="Minvoice-btn Minvoice-btn-search">Search</button>
             <button class="Minvoice-btn Minvoice-btn-reset">Reset</button>
         </div>
     </div>

     <!-- Table -->
     <div class="Minvoice-table-wrapper">
         <table class="Minvoice-table">
             <thead>
                 <tr>
                     <th style="width: 12%">Invoice No</th>
                     <th style="width: 10%">Invoice Date</th>
                     <th style="width: 30%">Works</th>
                     <th style="width: 16%">Company</th>
                     <th style="width: 12%">Total Invoice Amount</th>
                     <th style="width: 10%">Receipt Date</th>
                     <th style="width: 10%">Receipt No</th>
                     <th style="width: 10%">Amount</th>
                     <th style="width: 12%">Action</th>
                 </tr>
             </thead>
             <tbody>
                 <!-- Opening balance row -->
                 <tr class="Minvoice-opening-row">
                     <td colspan="9" class="Minvoice-opening-label">OpeningBalance</td>
                 </tr>

                 <!-- Data row -->
                 <tr>
                     <td>KSA/HO/25-26/11</td>
                     <td>19-06-2025</td>
                     <td class="Minvoice-works-text">
                         Internal Audit (25061901), Statutory Audit (25061902), Other
                         Legal Work (25061903), Other Legal Work (25061904), CA
                         Certification (25061905), Certification (25061906), Consultancy
                         Charges (25061907)
                     </td>
                     <td>Meenakshi Company</td>
                     <td class="Minvoice-text-right">125080.00</td>
                     <td>06-01-2026</td>
                     <td>Amount-</td>
                     <td class="Minvoice-text-right">125080</td>
                     <td>
                         <button class="Minvoice-btn Minvoice-btn-primary" style="padding: 4px 8px; font-size: 12px">
                             Print &amp; Preview
                         </button>
                     </td>
                 </tr>

                 <!-- Total row -->
                 <tr class="Minvoice-total-row">
                     <td colspan="4" class="Minvoice-text-right">Total</td>
                     <td class="Minvoice-text-right Minvoice-amount-bold">
                         125080.00
                     </td>
                     <td colspan="2" class="Minvoice-closing-balance">
                         Closing<br />Balance
                     </td>
                     <td class="Minvoice-text-right Minvoice-amount-bold">125080</td>
                     <td></td>
                 </tr>
             </tbody>
         </table>
     </div>

     <!-- Pagination -->
     <div class="Minvoice-pagination">
         <button>&lt;&lt;</button>
         <button class="Minvoice-active">1</button>
         <button>&gt;&gt;</button>
     </div>
 </div>