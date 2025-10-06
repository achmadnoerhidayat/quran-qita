<div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white w-full max-w-sm p-6 rounded shadow-lg relative">

        <button onclick="closeErrorModal()"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>

        {{ $slot }}

        <div class="mt-4 text-right">
            <button onclick="closeErrorModal()"
                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Tutup</button>
        </div>
    </div>
</div>
