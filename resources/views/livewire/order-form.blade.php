<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $editing ? 'Edit Order' : 'Create Order' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div>
                            <x-input-label class="mb-1" for="customer" :value="__('Customer')"/>
                            <select class="mt-1 select2" id="customer" name="customer" wire:model="order.user_id">
                                @forelse($listsForFields['users'] as $key=> $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @empty
                                    <option>Enter customer</option>
                                @endforelse

                            </select>

                            <x-input-error :messages="$errors->get('order.user_id')" class="mt-2"/>
                        </div>

                        <div class="mt-4">
                            <x-input-label class="mb-1" for="order_date" :value="__('Order date')"/>

                            <input
                                type="date"
                                id="order_date"
                                wire:model="order.order_date"
                                autocomplete="off"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                            <x-input-error :messages="$errors->get('order.order_date')" class="mt-2"/>
                        </div>

                        {{-- Order Products --}}
                        <table class="mt-4 min-w-full border divide-y divide-gray-200">
                            <thead>
                            <th class="px-6 py-3 text-left bg-gray-50">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Product</span>
                            </th>
                            <th class="px-6 py-3 text-left bg-gray-50">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Quantity</span>
                            </th>
                            <th class="px-6 py-3 w-56 text-left bg-gray-50"></th>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            @forelse($orderProducts as $index => $orderProduct)
                                <tr>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        @if($orderProduct['is_saved'])
                                            <input type="hidden" name="orderProducts[{{$index}}][product_id]"
                                                   wire:model="orderProducts.{{$index}}.product_id"/>
                                            @if($orderProduct['product_name'] && $orderProduct['product_price'])
                                                {{ $orderProduct['product_name'] }}
                                                (${{ number_format($orderProduct['product_price'] / 100, 2) }})
                                            @endif
                                        @else
                                            <select name="orderProducts[{{ $index }}][product_id]"
                                                    class="focus:outline-none w-full border {{ $errors->has('$orderProducts.' . $index) ? 'border-red-500' : 'border-indigo-500' }} rounded-md p-1"
                                                    wire:model="orderProducts.{{ $index }}.product_id">
                                                <option value="">-- choose product --</option>
                                                @foreach ($this->allProducts as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}
                                                        (${{ number_format($product->price / 100, 2) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('orderProducts.' . $index)
                                            <em class="text-sm text-red-500">
                                                {{ $message }}
                                            </em>
                                            @enderror
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        @if($orderProduct['is_saved'])
                                            <input type="hidden" name="orderProducts[{{$index}}][quantity]"
                                                   wire:model="orderProducts.{{$index}}.quantity"/>
                                            {{ $orderProduct['quantity'] }}
                                        @else
                                            <input type="number" step="1" name="orderProducts[{{$index}}][quantity]"
                                                   class="p-1 w-full rounded-md border border-indigo-500 focus:outline-none"
                                                   wire:model="orderProducts.{{$index}}.quantity"/>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        @if($orderProduct['is_saved'])
                                            <x-primary-button wire:click.prevent="editProduct({{$index}})">
                                                Edit
                                            </x-primary-button>
                                        @elseif($orderProduct['product_id'])
                                            <x-primary-button wire:click.prevent="saveProduct({{$index}})">
                                                Save
                                            </x-primary-button>
                                        @endif
                                        <button
                                            class="px-4 py-2 ml-1 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300"
                                            wire:click.prevent="removeProduct({{$index}})">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3"
                                        class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        Start adding products to order.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <x-primary-button wire:click.prevent="addProduct">+ Add Product</x-primary-button>
                        </div>
                        {{-- End Order Products --}}

                        <div class="flex justify-end">
                            <table>
                                <tr>
                                    <th class="text-left p-2">Subtotal</th>
                                    <td class="p-2">${{ number_format($order->subtotal / 100, 2) }}</td>
                                </tr>
                                <tr class="text-left border-t border-gray-300">
                                    <th class="p-2">Taxes ({{ $taxesPercent }}%)</th>
                                    <td class="p-2">
                                        ${{ number_format($order->taxes / 100, 2) }}
                                    </td>
                                </tr>
                                <tr class="text-left border-t border-gray-300">
                                    <th class="p-2">Total</th>
                                    <td class="p-2">${{ number_format($order->total / 100, 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-4">
                            <x-primary-button type="submit">
                                Save
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
