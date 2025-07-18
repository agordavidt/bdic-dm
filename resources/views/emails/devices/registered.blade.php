<x-mail::message>
# Hello {{ $buyerName }},

A device has been registered to your email address on {{ config('app.name') }}.

**Device Details:**
- **Device:** {{ $device->brand }} {{ $device->model }}
- **Unique Identifier:** {{ $device->unique_identifier }}
- **Registered By:** {{ $device->vendor->name ?? 'Vendor' }}

You can log in or sign up to track your device, view warranty, or report faults.

<x-mail::button :url="url('/login')">
Go to Device Portal
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
