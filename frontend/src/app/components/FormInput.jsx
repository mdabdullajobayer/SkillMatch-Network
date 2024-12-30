import React from "react";

const FormInput = ({ id, label, type, placeholder, required }) => (
    <div className="mb-3">
        <label htmlFor={id} className="form-label">
            {label}
        </label>
        <input
            type={type}
            className="form-control"
            id={id}
            placeholder={placeholder}
            required={required}
        />
    </div>
);

export default FormInput;
