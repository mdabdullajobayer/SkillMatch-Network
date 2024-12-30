'use client';
import React, { useState } from "react";
import LoginForm from "./components/LoginForm";
import { loginUser } from "./services/login_api";
import { useRouter } from 'next/navigation';

export default function Home() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const [Success, setSuccess] = useState("");
  const { push } = useRouter();
  const handleEmailChange = (e) => setEmail(e.target.value);
  const handlePasswordChange = (e) => setPassword(e.target.value);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    try {
      const data = await loginUser(email, password);
      if (data.token) {
        setSuccess("Login successful.");
        localStorage.setItem("authToken", data.token);
        setTimeout(() => {
          push("/dashboard");
        }, 1000);
      }
    } catch (err) {
      console.error("Login failed:", err);
      setError(err.message);
      setLoading(false);
    } finally {
      setLoading(false);
    }
  };

  return (
    <LoginForm
      onSubmit={handleSubmit}
      email={email}
      password={password}
      onEmailChange={handleEmailChange}
      onPasswordChange={handlePasswordChange}
      error={error}
      success={Success}
      loading={loading}
    />
  );
}
