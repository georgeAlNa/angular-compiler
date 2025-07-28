<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Response Messages
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for API responses throughout
    | the application. These messages are returned to the client in JSON format.
    |
    */

    // Success Messages
    'data_retrieved_successfully' => 'Data retrieved successfully',
    'created_successfully' => 'Record created successfully',
    'updated_successfully' => 'Record updated successfully',
    'deleted_successfully' => 'Record deleted successfully',
    'bulk_created_successfully' => 'Records created successfully',
    'bulk_updated_successfully' => 'Records updated successfully',

    // Error Messages
    'error_retrieving_data' => 'Error retrieving data',
    'error_creating_record' => 'Error creating record',
    'error_updating_record' => 'Error updating record',
    'error_deleting_record' => 'Error deleting record',
    'record_not_found' => 'Record not found',
    'validation_failed' => 'Validation failed',
    'unauthorized_access' => 'Unauthorized access',
    'unauthenticated' => 'Authentication required',
    'business_logic_error' => 'Business logic error',
    'server_error' => 'Internal server error',
    'route_not_found' => 'Route not found',
    'method_not_allowed' => 'Method not allowed',

    // Validation Messages (nested structure for custom validation)
    'validation' => [
        'required' => 'The :attribute field is required.',
        'unique' => 'The :attribute has already been taken.',
        'exists' => 'The selected :attribute is invalid.',
    ],

    // Attribute Names
    'attributes' => [
        'name' => 'Name',
        'location' => 'Location',
        'governorate' => 'Governorate',
    ],
];
