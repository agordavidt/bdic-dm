Project Flow
1. Authentication & Registration
Registration: Users can register as either a Buyer or Vendor. Vendors must provide a company name; buyers provide personal details.
Login: All users authenticate via standard Laravel authentication. After login, users are redirected to their role-specific dashboard based on their user role (admin, vendor, buyer, manufacturer).
2. Dashboards
Role-based Dashboards:
Admin: Sees total users, vendors, buyers, and devices, with access to user management and analytics.
Vendor: Views device management, sales, and a dashboard summarizing their inventory and sales.
Buyer: Sees owned devices, active/resolved reports, and can report faults or flag devices as stolen.
Manufacturer: Manages device categories and can view all devices.
3. Device Management
Device Registration: Vendors register devices, entering unique identifiers and buyer information. Devices are linked to both the vendor and the buyer.
Device Categories: Admins and manufacturers can create and manage device categories.
Device Transfer: Devices can be transferred between users (e.g., from vendor to buyer, or between buyers).
Device Status: Devices can be flagged for attention, replacement, or as stolen. Buyers can flag their own devices as stolen.
4. Buyer Profile & Purchase History
Buyer Profiles: Created/updated when a device is registered to a buyer. Stores full name, contact, address, ID, and buyer type (individual, institution, corporate).
Purchase History: The system tracks all devices owned by a buyer.
5. Fault Reporting & Support
Buyers can report device faults via the dashboard.
Vendors/Manufacturers see real-time dashboards of reported faults and can respond or update device status.
Support can flag devices for attention or replacement.
6. Analytics & Reporting
Admins/BDIC Management: Access analytics on sales, vendor performance, and geographical distribution.
Manufacturers: Can view analytics relevant to device categories and performance.
Key User Stories (from README and code)
ID	User Story	Role
FR001	Register a device with a unique identifier.	Vendor
FR002	Enter device and buyer details during registration.	Vendor
FR003	Tag devices by buyer category (individual, institution, corporate).	Vendor
FR004	Onboard new vendors and manage their inventory.	Admin
FR005	Track vendor sales and performance metrics.	Admin/BDIC Mgmt
FR006	Track buyer identities and purchase history.	Admin/BDIC Mgmt
FR007	Report device faults via the portal.	Buyer
FR008	View reported faults on a real-time dashboard.	Vendor/Manufacturer
FR009	Flag devices for attention or replacement based on faults.	Support
FR010	Flag a device as stolen.	Buyer
FR011	Remotely track or shut down a stolen device (for supported devices).	BDIC IT/Support
FR012	View geographical sales analytics.	Admin/BDIC Mgmt
Typical User Flows
Vendor
Logs in → Accesses dashboard.
Registers a new device, entering buyer info and selecting buyer category.
Views/manage their devices and sales.
Sees fault reports for devices they sold.
Buyer
Logs in → Accesses dashboard.
Views list of owned devices.
Reports a fault or flags a device as stolen.
Sees status of their reports and device resolutions.
Admin
Logs in → Accesses admin dashboard.
Manages users, vendors, and device categories.
Views analytics and sales performance.
Onboards new vendors.
Manufacturer
Logs in → Accesses manufacturer dashboard.
Manages device categories.
Views all devices and reported faults.
Security & Access Control
Role-based Middleware: Ensures only users with the correct role can access certain routes and features.
Policies: Fine-grained control over who can view, update, transfer, or delete devices.
Summary
The BDIC Device Management System is a robust, role-driven platform for tracking devices from sale to end-of-life, supporting after-sales service, and providing actionable insights for management. The flow is centered around device registration, ownership transfer, fault reporting, and analytics, with each user role having a clear set of capabilities and dashboards.
If you want a diagram or a more technical breakdown of any specific flow (e.g., device registration, fault reporting), let me know!


