<div class="pt-3" id="row{{ $key }}">
    <dt>
        <!-- Expand/collapse question button -->
        <button type="button" class="flex w-full items-start justify-between text-left text-gray-900" aria-controls="faq-0" aria-expanded="false"
            x-on:click.prevent="active === {{ $key }} ? (active = null) : (active = {{ $key }})"
        >
            <span class="text-base font-semibold leading-7">{{ $title }}</span>
            <span class="ml-6 flex h-7 items-center">
                <svg x-bind:class="active === {{ $key }} ? 'hidden' : ''" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                </svg>
                <svg x-bind:class="active === {{ $key }} ? '' : 'hidden'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                </svg>
              </span>
        </button>
    </dt>
    <dd class="bg-gray-100 mt-0 pr-0" id="faq-0" x-show="active === {{ $key }}">
        {{ $slot }}
    </dd>
</div>