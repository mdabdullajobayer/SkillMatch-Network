import Link from "next/link";
import React from "react";

const LoginForm = ({ onSubmit, email, password, onEmailChange, onPasswordChange, error, loading, success }) => (
    <div className="container d-flex justify-content-center align-items-center vh-100">
        <div className="card p-4 shadow-sm" style={{ width: "24rem" }}>
            <h3 className="text-center mb-4">Login</h3>
            {error && <div className="alert alert-danger">{error}</div>}
            {success && <div className="alert alert-success">{success}</div>}
            <form onSubmit={onSubmit}>
                <div className="mb-3">
                    <label htmlFor="email" className="form-label">
                        Email
                    </label>
                    <input
                        type="email"
                        className="form-control"
                        id="email"
                        placeholder="Enter your email"
                        value={email}
                        onChange={onEmailChange}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label htmlFor="password" className="form-label">
                        Password
                    </label>
                    <input
                        type="password"
                        className="form-control"
                        id="password"
                        placeholder="Enter your password"
                        value={password}
                        onChange={onPasswordChange}
                        required
                    />
                </div>
                <button type="submit" className="btn btn-primary w-100" disabled={loading}>
                    {loading ? "Logging in..." : "Login"}
                </button>
                <p className="text-center mt-3">
                    Don't have an account? <Link href="/register">Register</Link>
                </p>
            </form>
        </div>
    </div>
);

export default LoginForm;
