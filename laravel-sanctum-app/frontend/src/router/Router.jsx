import {  Route, Routes } from "react-router-dom";
import { Login } from "../components/page/Login";
import { Todos } from "../components/page/Todos";
import { User } from "../components/page/User";

export const Router = () => {

  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/todos" element={<Todos />} />
      <Route path="/user" element={<User />} />
    </Routes>
  )
} 
