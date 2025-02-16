import { NextResponse } from "next/server";

export function middleware(request) {
    const token = request.cookies.get("authToken");
    if (!token) {
        console.log("Redirecting to login...");
        return NextResponse.redirect(new URL("/", request.url));
    }

    console.log("Token found. Proceeding...");
    return NextResponse.next();
}

export const config = {
    matcher: ["/dashboard/:path*", "/profile/:path*"],
};
