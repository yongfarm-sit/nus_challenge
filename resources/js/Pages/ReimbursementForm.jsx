import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';

export default function ReimbursementForm() {
  const [formData, setFormData] = useState({
    vendor_name: '',
    purchase_date: '',
    total_amount: '',
    currency: 'USD',
    payment_method: '',
    category: '',
    receipt_img: null,
  });

  const handleChange = (e) => {
    const { name, value, files } = e.target;
    setFormData({
      ...formData,
      [name]: files ? files[0] : value,
    });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    const formDataObj = new FormData();
    Object.entries(formData).forEach(([key, value]) => {
      formDataObj.append(key, value);
    });

    Inertia.post('/reimbursements', formDataObj);
  };

  return (
    <div>
      <h2>Reimbursement Receipt Form</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="vendor_name">Vendor Name:</label>
          <input
            type="text"
            name="vendor_name"
            value={formData.vendor_name}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="purchase_date">Purchase Date:</label>
          <input
            type="date"
            name="purchase_date"
            value={formData.purchase_date}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="total_amount">Total Amount:</label>
          <input
            type="number"
            name="total_amount"
            value={formData.total_amount}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="currency">Currency:</label>
          <select
            name="currency"
            value={formData.currency}
            onChange={handleChange}
            required
          >
            <option value="SGD">SGD</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            {/*Add other currencies as needed*/}
          </select>
        </div>

        <div>
          <label htmlFor="payment_method">Payment Method:</label>
          <input
            type="text"
            name="payment_method"
            value={formData.payment_method}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="category">Category:</label>
          <input
            type="text"
            name="category"
            value={formData.category}
            onChange={handleChange}
            required
          />
        </div>

        <div>
          <label htmlFor="receipt_img">Upload Receipt:</label>
          <input
            type="file"
            name="receipt_img"
            onChange={handleChange}
            accept="image/*,application/pdf"
            required
          />
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>
  );
}
