<div class="relative w-full max-w-md" id="input">
    <!-- Input search -->
    <input type="text" name="search" value="{{ request('search') }}" id="floating_outlined" 
        placeholder="{{ $placeholder }}"
        class="block w-full text-sm h-[38px] px-3 text-blue-900 bg-white rounded-lg border border-blue-300 appearance-none 
               focus:border-transparent focus:outline focus:outline-2 focus:outline-blue-500 focus:ring-0 
               hover:border-blue-400 peer invalid:border-red-500 invalid:focus:border-red-500 overflow-ellipsis overflow-hidden text-nowrap pr-[42px]" />

    <!-- Floating label -->
    <label for="floating_outlined"
        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[12px] leading-[150%] text-blue-500 
               peer-focus:text-blue-500 peer-invalid:text-red-500 focus:invalid:text-red-500 duration-300 
               transform -translate-y-[1rem] scale-75 top-1 z-10 origin-[0] bg-white px-2 
               peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 
               peer-placeholder-shown:top-1/2 peer-focus:top-1 peer-focus:scale-75 peer-focus:-translate-y-[1rem]">
        {{ $placeholder }}
    </label>

    <!-- Icon search -->
    <div class="absolute top-2 right-2 text-blue-400">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="20"
            width="20">
            <!-- ... path ... -->
        </svg>
    </div>

    <!-- Reset button -->
    @if (request('search'))
        <a href="{{ route($route) }}"
            class="absolute top-2 right-8 bg-blue-100 text-blue-600 p-1 rounded-full hover:bg-blue-200 transition flex items-center justify-center"
            title="Reset Pencarian">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    @endif
</div>