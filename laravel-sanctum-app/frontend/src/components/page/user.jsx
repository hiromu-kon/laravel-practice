import { useState, useEffect } from "react"
import axios from 'axios';
import { useNavigate } from "react-router-dom";

export const User = () => {
  const [user, setUser] = useState('');
  const navigate= useNavigate();

  useEffect(() => {
    axios
    .get(
      'http://localhost:8000/api/user', { withCredentials: true })
    .then((res) => {
      console.log(res.data);
      setUser(res.data);
    })
    .catch((e) => {
      if (e.response.status === 401) return navigate("/login");
    })
  }, [])

  return (
    <div>
      <h1>Userページ</h1>
      <p>id: {user.id}</p><br/>
      <p>name: {user.name}</p><br/>
      <p>email: {user.email}</p><br/>
    </div>
  )
}
