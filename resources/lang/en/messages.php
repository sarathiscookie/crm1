<?php
return [

    /*
   |--------------------------------------------------------------------------
   | Messages in dashboard page (dashboard)
   |--------------------------------------------------------------------------
   |
   */
    // do here
    /*
    /*
    |--------------------------------------------------------------------------
    | Messages in header page (include-header)
    |--------------------------------------------------------------------------
    |
    */
    'headerSearchPlaceholder'                    => 'Search',
    /*
    |--------------------------------------------------------------------------
    | Messages in customer listing page (admin)
    |--------------------------------------------------------------------------
    |
    */
    'customerListPageHeading'                    => 'Customers',
    'customerListPageTableHeading'               => 'All Customers',
    'customerListTableFirstname'                 => 'First name',
    'customerListTableLastname'                  => 'Last name',
    'customerListTableMail'                      => 'Email',
    'customerListTablePhone'                     => 'Phone',
    'customerListTableCreated'                   => 'Added',
    'customerListPageCreateCustomerButton'       => 'Create Customer',

    /*
    |--------------------------------------------------------------------------
    | Messages in create customer (createCustomer)
    |--------------------------------------------------------------------------
    |
    */
    'customerCreatePageHeading'                   => 'Create customer',
    'customerCreateFormLabelFirstName'            => 'Firstname',
    'customerCreateFormLabelLastName'             => 'Lastname',
    'customerCreateFormLabelEmail'                => 'Email',
    'customerCreateFormLabelDOB'                  => 'Birth date',
    'customerCreateFormLabelPhone'                => 'Phone',
    'customerCreateFormLabelStreet'               => 'Street',
    'customerCreateFormLabelPostal'               => 'Postal',
    'customerCreateFormLabelCity'                 => 'City',
    'customerCreateFormLabelCountry'              => 'Country',
    'customerCreateFormLabelStatus'               => 'Status',
    'customerCreateFormSubmitButton'              => 'Save customer',
    'customerCreateFormSubmitButton2'             => 'Save customer and Create order',
    'customerCreatedSuccessMsg'                   => 'Customer created successfully',
    'customerAndOrderCreatedSuccessMsg'           => 'Customer and order created successfully',
    'customerCreateErrorMsg'                      => 'Customer not created',

    /*
    |--------------------------------------------------------------------------
    | Messages in edit customer (editCustomer)
    |--------------------------------------------------------------------------
    |
    */
    'customerEditPageHeading'                      => 'Edit customer',
    'customerEditFormLabelFirstName'               => 'Firstname',
    'customerEditFormLabelLastName'                => 'Lastname',
    'customerEditFormLabelEmail'                   => 'Email',
    'customerEditFormLabelDOB'                     => 'Birth date',
    'customerEditFormLabelPhone'                   => 'Phone',
    'customerEditFormLabelStreet'                  => 'Street',
    'customerEditFormLabelPostal'                  => 'Postal',
    'customerEditFormLabelCity'                    => 'City',
    'customerEditFormLabelCountry'                 => 'Country',
    'customerEditFormLabelStatus'                  => 'Status',
    'customerEditFormSubmitButton'                 => 'Update customer',
    'customerStatusCustomer'                       => 'Customer',
    'customerStatusVip'                            => 'Vip',
    'customerStatusBlocked'                        => 'Blocked',
    'customerStatusDeleted'                        => 'Deleted',

    /*
    |--------------------------------------------------------------------------
    | Messages in customer details page
    |--------------------------------------------------------------------------
    |
    */
    /*Customer details*/
    'customerDetailPageHeading'                         => 'Customer Detail',
    'customerDetailsBookingTableHeading'                => 'Booking List',
    'customerDetailsBookingTableOrderId'                => 'Order Id',
    'customerDetailsBookingTableInvoiceId'              => 'Invoice Id',
    'customerDetailsBookingTableStatus'                 => 'Status',
    'customerDetailsBookingTableDate'                   => 'Date',
    'customerDetailsBookingNoRecords'                   => 'No bookings found',
    'customerDetailsCreateMembershipButton'             => 'Create Membership',
    'createMembershipModalLabel'                        => 'Create Membership',
    'createMembershipFormLabelSchool'                   => 'Golf school',
    'createMembershipFormButtonClose'                   => 'Close',
    'createMembershipFormButtonSave'                    => 'Save',
    'customerDetailCreateOrderButton'                    => 'Create Order',
    'customerOrderCreatedSuccessMsg'                    => 'Order created successfully',


    /*
    |--------------------------------------------------------------------------
    | Messages in Booking listing page (admin)
    |--------------------------------------------------------------------------
    |
    */
    'bookingListPageHeading'                    => 'Bookings',
    'bookingListPageTableHeading'               => 'Booking List',
    'bookingListTableOrderId'                   => 'Order Id',
    'bookingListTableInvoiceId'                 => 'Invoice Id',
    'bookingListTableStatus'                    => 'Status',
    'bookingListTableDate'                      => 'Date',
    'bookingStatusOfferedLabel'                 => 'Offered',
    'bookingStatusBookedLabel'                  => 'Booked',
    'bookingStatusConfirmedLabel'               => 'Confirmed',
    'bookingStatusFinishedLabel'                => 'Finished',

    /*
    |--------------------------------------------------------------------------
    | Messages in Booking details page (admin)
    |--------------------------------------------------------------------------
    |
    */
    'bookingDetailsPageHeading'                 => 'Booking Details',
    'bookingDetailsBreadcrumb1'                 => 'Home',
    'bookingDetailsBreadcrumb2'                 => 'Bookings',
    'bookingDetailsBreadcrumb3'                 => 'Booking Details',
    'bookingDetailsTableHead'                   => 'Booking Details',
    'bookingDetailsTableHeadSource'             => 'Source',
    'bookingDetailsTableHeadPayedAt'            => 'Payed At',
    'bookingDetailsTableHeadCancelledAt'        => 'Cancelled At',
    'bookingDetailsTableHeadCreatedAt'          => 'Created At',
    'bookingDetailsTableHeadUpdatedAt'          => 'Updated At',
    'bookingDetailsPositionTableHead'           => 'Booking Positions',
    'bookingDetailsPositionTableHeadTitle'      => 'Title',
    'bookingDetailsPositionTableHeadDesc'       => 'Description',
    'bookingDetailsPositionTableHeadprice'      => 'Price',
    'bookingDetailsPositionTableHeadQuan'       => 'Quantity',
    'bookingDetailsPositionNoDataMsg'           => 'No order positions found',
    'bookingDetailsPassengersTableHead'         => 'Booking Passengers',
    'bookingDetailsPassengersTableHeadCust'     => 'Customer',
    'bookingDetailsPassengersNoDataMsg'         => 'No order passengers found',
    'bookingDetailsCreatePositionButton'        => 'Create Position',
    'bookingDetailsFinanceTableHead'            => 'Finance Details',
    'bookingDetailsCreateIncomingInvoice'       => 'Create Incoming Invoice',
    'incomingInvoiceModalLabel'                 => 'Create Incoming Invoice',
    'incomingInvoiceFormLabelTotal'             => 'Total',
    'incomingInvoiceFormLabelFreetext'          => 'Freetext',
    'incomingInvoiceFormButtonClose'            => 'Close',
    'incomingInvoiceFormButtonSave'             => 'Save',
    'bookingDetailsDownloadInvoiceButton'       => 'Download Invoice',
    'bookingDetailsSendInvoiceButton'           => 'Recreate & send Invoice',


    /*
    |--------------------------------------------------------------------------
    | Messages in position update page (admin)
    |--------------------------------------------------------------------------
    |
    */
    'positionUpdatePageHeading'                 => 'Position Update',
    'positionUpdatePageBreadcrumb1'             => 'Home',
    'positionUpdatePageBreadcrumb2'             => 'Bookings',
    'positionUpdatePageBreadcrumb3'             => 'Booking Details',
    'positionUpdatePageBreadcrumb4'             => 'Position',
    'positionUpdatePageFormUpdateButton'        => 'Update',
    'positionUpdatePageFormUpdateMsg'           => 'Position updated successfully',
    'positionUpdatePageMetaListHead'            => 'Position Metas',
    'positionUpdatePageCreateMetaButton'        => 'Create Meta',
    'positionMetaUpdateMsg'                     => 'Metas updated successfully',
    'positionMetaUpdateButton'                  => 'Update',
    'positionMetaNameCourseBegin'               => 'Course Begin',
    'positionMetaNameCourseEnd'                 => 'Course End',
    'positionMetaNameCourseType'                => 'Course Type',
    'positionMetaNameCourseDetails'             => 'Course Details',
    'positionMetaNameSchoolId'                  => 'School Id',
    'positionMetaNameSchoolDetails'             => 'School Details',
    'positionMetaNameHotelId'                   => 'Hotel Id',
    'positionMetaNameHotelBegin'                => 'Hotel Begin',
    'positionMetaNameHotelEnd'                  => 'Hotel End',
    'positionMetaNameHotelDetails'              => 'Hotel Details',
    'createPositionMetaModalLabel'              => 'Create Meta',
    'createPositionMetaFormLabelName'           => 'Meta Name',
    'createPositionMetaFormLabelValue'          => 'Meta Value',
    'createPositionMetaFormButtonClose'         => 'Close',
    'createPositionMetaFormButtonSave'          => 'Save',

    /*
    |--------------------------------------------------------------------------
    | Messages in position save page (admin)
    |--------------------------------------------------------------------------
    |
    */
    'positionSavePageHeading'                   => 'Position Create',
    'positionSavePageBreadcrumb1'               => 'Home',
    'positionSavePageBreadcrumb2'               => 'Bookings',
    'positionSavePageBreadcrumb3'               => 'Booking Details',
    'positionSavePageBreadcrumb4'               => 'Position',
    'positionSavePageFormUpdateButton'          => 'Create',
    'positionSavePageFormUpdateMsg'             => 'Position saved successfully',

    /* Position create and update form labels*/
    'positionUpdatePageTableTitle'              => 'Title',
    'positionUpdatePageTableDesc'               => 'Desc',
    'positionUpdatePageTablePrice'              => 'Price',
    'positionUpdatePageTableCost'               => 'Cost',
    'positionUpdatePageTableQuantity'           => 'Quantity',
    'positionUpdatePageTableType'               => 'Type',
    'positionUpdatePageTableTypeCourse'         => 'Course',
    'positionUpdatePageTableTypeHotel'          => 'Hotel',
    'positionUpdatePageTableTypeBundle'         => 'Bundle',
    'positionUpdatePageTableTypeOther'          => 'Other',

    /*
     |-------------------------------------------------------------
     | Messages in Memberships
     |-------------------------------------------------------------
     |
    */
    'membershipListPageHeading'                    => 'Memberships',
    'membershipListRenewButton'                    => 'Renew Membership',
    'membershipListPageTableHeading'               => 'All Memberships',
    'membershipListTableFirstname'                 => 'First name',
    'membershipListTableLastname'                  => 'Last name',
    'membershipListTableJoined'                    => 'Joined',
    'membershipListTableRenewed'                   => 'Renewed',
    'membershipListTableCancelled'                 => 'Cancelled',

    /*
    |--------------------------------------------------------------------------
    | Messages in personal list hotel ans school (admin)
    |--------------------------------------------------------------------------
    |
    */

    /* Hotel */
    'personalListHotelBreadcrumb1'   => 'Home',
    'personalListHotelBreadcrumb2'   => 'Person List',
    'personalListHotelBreadcrumb3'   => 'Hotel',
    'personalListHotelCardHeading'   => 'Hotel',
    'personalListHotelHeading'       => 'List of all hotels',
    'personalListHotelButton'        => 'Generate PDF',

    /* School */

    'personalListSchoolBreadcrumb1'   => 'Home',
    'personalListSchoolBreadcrumb2'   => 'Person List',
    'personalListSchoolBreadcrumb3'   => 'School',
    'personalListSchoolCardHeading'   => 'School',
    'personalListSchoolHeading'       => 'List of all schools',
    'personalListSchoolButton'        => 'Generate PDF',
    ];