export const resolveType = (value, types) => {
    return types[value] || { color: 'warning', text: 'Pending' };
  };

  // Configuration for types
  export const purposeTypes = {
    1: { color: 'warning', text: 'Business' },
    2: { color: 'success', text: 'Personal' },
    3: { color: 'info', text: 'Other' },
  };

  export const facilityTypes = {
    1: { color: 'primary', text: 'Meeting Room 1' },
    2: { color: 'primary', text: 'Meeting Room 2' },
    3: { color: 'primary', text: 'Meeting Room 3' },
  };

  export const statusTypes = {
    approved: { color: 'success', text: 'Approved' },
    rejected: { color: 'error', text: 'Rejected' },
    pending: { color: 'warning', text: 'Pending' },
  };
