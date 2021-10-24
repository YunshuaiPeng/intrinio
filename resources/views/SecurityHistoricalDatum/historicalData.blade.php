<x-app-layout>
    <security-historical-datum
        :security='@json($security)'
        :frequencies='@json($frequencies)'
    >
    </security-historical-datum>
</x-app-layout>
