import {  Route, Routes } from "react-router-dom";
import { Login } from "../components/page/login";
import { Todos } from "../components/page/todos";
import { User } from "../components/page/user";

export const Router = () => {

  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route path="/todos" element={<Todos />} />
      <Route path="/user" element={<User />} />
    </Routes>
  )
} 
