<style>
    .input-group-append .btn {
        height: 100%;
        display: flex;
        /* Flexbox for centering */
        align-items: center;
        /* Center the icon vertically */
        justify-content: center;
        /* Center the icon horizontally (if needed) */
        padding: 0 12px;
        /* Adjust padding to control button width */

    }

    /* Optional: Adjust the font size of the icon if needed */
    .input-group-append .material-symbols-outlined {
        font-size: 18px;
        /* Adjust size as needed */
        line-height: 1;
        /* Ensure no extra space */
    }
</style>

<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Recipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" id="recipeLink" class="form-control" value="{{ url()->current() }}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="copyButton"
                            style="border-block-color: none">
                            <span class="material-symbols-outlined">content_copy</span>
                        </button>
                    </div>
                </div>
                <!-- New PDF download button -->
                <div class="mt-3">
                    <a href="{{ route('download.recipe.pdf', ['id' => $recipeID]) }}" class="btn btn-primary">
                        Download as PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('copyButton').addEventListener('click', function() {
        const copyText = document.getElementById('recipeLink');
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
        alert('Link copied to clipboard');
    });
</script>
