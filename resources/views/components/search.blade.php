<form wire:submit.prevent="" class="search-form mb-3">
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text" style="border-color: #FFFFFF; background-color: #FFFFFF">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        </div>
        <input wire:model.debounce.500ms="search"
               style="background-color: #FFFFFF;
               border: 1px solid #ffffff!important"
               type="text"
               class="input-group-text form-control-plaintext border text-left"
               id="navbarForm"
               placeholder="Search here...">
    </div>
</form>
