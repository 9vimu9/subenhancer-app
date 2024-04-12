<x-dashboard.layout>
<x-dashboard.header>
        <x-slot:title>Dashboard</x-slot:title>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sunt, assumenda dignissimos doloremque
        reiciendis autem iusto saepe ut minima nesciunt?
    </x-dashboard.header>

    <section class="mt-8 flex flex-col md:flex-row gap-8">
        <x-dashboard.card>
            <x-slot:title>2021 Stats</x-slot:title>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eveniet, necessitatibus!
        </x-dashboard.card>
        <x-dashboard.card>
            <x-slot:title>2022 Stats</x-slot:title>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad, fugit.
        </x-dashboard.card>
    </section>

    <section class="mt-12">
        <x-dashboard.table />
    </section>


</x-dashboard.layout>
