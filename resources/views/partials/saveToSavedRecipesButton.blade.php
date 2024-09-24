<div class="save-button-container">
    <form action="{{ route('home.saveRecipeFromHome', $recipe->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning" style="border-radius: 20px; text-align: center;">
            +
        </button>
    </form>
</div>
