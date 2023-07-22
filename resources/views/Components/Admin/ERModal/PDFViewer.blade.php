<!-- Modal -->
<div class="modal modal-xl fade" id="er_modal-pdfviewer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="er_modal_label-pdfviewer" aria-hidden="true">
  
  <div class="modal-dialog">
    
    <div class="modal-content">
      
        <div class="modal-header">
            <span class="modal-title" id="er_modal_label-pdfviewer">Title</span>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <object  id="embed_pdf_viewer" data="{{ asset('storage/generated_pdfs/PhilHealth - JsEC.pdf') }}" type="application/pdf" width="100%" height="500px"></object>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Refresh</button>
        </div>
    </div>
</div>

<script>
    function pdfviewer(id, url){
        // $('#er_modal_label-pdfviewer').html(id);
        $('#er_modal-pdfviewer').modal('show');
    }
</script>