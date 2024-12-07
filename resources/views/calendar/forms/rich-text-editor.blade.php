
<div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
    <div class="px-3 py-2 border-b dark:border-gray-600">
    <div class="flex items-center gap-2">
        <button id="typographyDropdownButton-{{ $idSuffix }}" data-dropdown-toggle="typographyDropdown-{{ $idSuffix }}" class="flex items-center justify-center rounded-lg bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-200 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-50 dark:bg-gray-600 dark:text-gray-400 dark:hover:bg-gray-500 dark:hover:text-white dark:focus:ring-gray-600" type="button">
            Format
            <svg class="-me-0.5 ms-1.5 h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
            </svg>
        </button>
        <div class="ps-1.5">
            <span class="block w-px h-4 bg-gray-300 dark:bg-gray-600"></span>
        </div>
        <!-- Heading Dropdown -->
        <div id="typographyDropdown-{{ $idSuffix }}" class="z-10 hidden w-72 rounded bg-white p-2 shadow dark:bg-gray-700">
            <ul class="space-y-1 text-sm font-medium" aria-labelledby="typographyDropdownButton-{{ $idSuffix }}">
                <li>
                    <button id="toggleParagraphButton-{{ $idSuffix }}" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Paragraph 
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">0</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button data-heading-level="1" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 1 
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">1</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button  data-heading-level="2" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 2 
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">2</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button  data-heading-level="3" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 3
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">3</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button  data-heading-level="4" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 4
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">4</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button data-heading-level="5" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 5
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">5</kbd>
                        </div>
                    </button>
                </li>
                <li>
                    <button  data-heading-level="6" type="button" class="flex justify-between items-center w-full text-base rounded px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">Heading 6
                        <div class="space-x-1.5">
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Cmd</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">Alt</kbd>
                            <kbd class="px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 border border-gray-200 rounded-lg dark:bg-gray-600 dark:text-gray-400 dark:border-gray-500">6</kbd>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
        <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">
            <button id="toggleCodeBlockButton-{{ $idSuffix }}" type="button" data-tooltip-target="tooltip-code-block-{{ $idSuffix }}" class="p-1.5 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 8-4 4 4 4m8 0 4-4-4-4m-2-3-4 14"/>
                </svg>
                <span class="sr-only">Toggle code block</span>
            </button>
            <div id="tooltip-code-block-{{ $idSuffix }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Toggle code block
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="toggleListButton-{{ $idSuffix }}" type="button" data-tooltip-target="tooltip-list-{{ $idSuffix }}" class="p-1.5 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
                </svg>
                <span class="sr-only">Toggle list</span>
            </button>
            <div id="tooltip-list-{{ $idSuffix }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Toggle list
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="toggleOrderedListButton-{{ $idSuffix }}" type="button" data-tooltip-target="tooltip-ordered-list-{{ $idSuffix }}" class="p-1.5 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4"/>
                </svg>
                <span class="sr-only">Create ordered list</span>
            </button>
            <div id="tooltip-ordered-list-{{ $idSuffix }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Toggle ordered list
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="toggleBlockquoteButton-{{ $idSuffix }}" type="button" data-tooltip-target="tooltip-blockquote-list-{{ $idSuffix }}" class="p-1.5 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M6 6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a3 3 0 0 1-3 3H5a1 1 0 1 0 0 2h1a5 5 0 0 0 5-5V8a2 2 0 0 0-2-2H6Zm9 0a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a3 3 0 0 1-3 3h-1a1 1 0 1 0 0 2h1a5 5 0 0 0 5-5V8a2 2 0 0 0-2-2h-3Z" clip-rule="evenodd"/>
                </svg>
                <span class="sr-only">Toggle blockquote</span>
            </button>
            <div id="tooltip-blockquote-list-{{ $idSuffix }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Toggle blockquote
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <button id="toggleHRButton-{{ $idSuffix }}" type="button" data-tooltip-target="tooltip-hr-list-{{ $idSuffix }}" class="p-1.5 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 12h14"/>
                    <path stroke="currentColor" stroke-linecap="round" d="M6 9.5h12m-12 9h12M6 7.5h12m-12 9h12M6 5.5h12m-12 9h12"/>
                </svg>
                <span class="sr-only">Toggle Horizontal Rule</span>
            </button>
            <div id="tooltip-hr-list-{{ $idSuffix }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Toggle Horizontal Rule
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</div>
<div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
    <label for="wysiwyg-typography-example-{{ $idSuffix }}" class="sr-only">Publish post</label>
    <div id="wysiwyg-typography-example-{{ $idSuffix }}"class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></div>
</div>
</div>
<script type="module">
    


window.addEventListener('load', function() {
    if (document.getElementById("wysiwyg-typography-example-{{ $idSuffix }}")) {

    // tip tap editor setup
    const editor = new Editor({
        element: document.querySelector('#wysiwyg-typography-example-{{ $idSuffix }}'),
        extensions: [
            StarterKit,
            HorizontalRule,
            CodeBlock
        ],
        editorProps: {
            attributes: {
                id : 'text-{{ $idSuffix }}',
                class: 'format lg:format-lg dark:format-invert focus:outline-none format-blue max-w-none',
            },
        }
    });
    
    // set up custom event listeners for the buttons
    document.getElementById('toggleListButton-{{ $idSuffix }}').addEventListener('click', () => {
       editor.chain().focus().toggleBulletList().run();
    });
    document.getElementById('toggleOrderedListButton-{{ $idSuffix }}').addEventListener('click', () => {
        editor.chain().focus().toggleOrderedList().run();
    });
    document.getElementById('toggleBlockquoteButton-{{ $idSuffix }}').addEventListener('click', () => {
        editor.chain().focus().toggleBlockquote().run();
    });
    document.getElementById('toggleHRButton-{{ $idSuffix }}').addEventListener('click', () => {
        editor.chain().focus().setHorizontalRule().run();
    });
    document.getElementById('toggleCodeBlockButton-{{ $idSuffix }}').addEventListener('click', () => {
        editor.chain().focus().toggleCodeBlock().run();
    });

    // typography dropdown
    const typographyDropdown = FlowbiteInstances.getInstance('Dropdown', 'typographyDropdown-{{ $idSuffix }}');

    document.getElementById('toggleParagraphButton-{{ $idSuffix }}').addEventListener('click', () => {
        editor.chain().focus().setParagraph().run();
        typographyDropdown.hide();
    });
    
    document.querySelectorAll(`#typographyDropdown-{{ $idSuffix }} [data-heading-level]`).forEach((button) => {
        button.addEventListener('click', () => {
            console.log('da')
            const level = button.getAttribute('data-heading-level');
            console.log(level)
            editor.chain().focus().toggleHeading({ level: parseInt(level) }).run()
            typographyDropdown.hide();
        });
    });
   
}
})


</script>