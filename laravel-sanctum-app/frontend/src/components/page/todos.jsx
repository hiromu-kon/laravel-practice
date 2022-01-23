import { useEffect } from "react"
import axios from 'axios';

export const Todos = () => {
  useEffect(() => {
    axios
    .get(
      'http://localhost:8000/api/todos', { withCredentials: true })
    .then((response) => {
      console.log(response.data)
    })
  }, [])

  return (
    <div>
      Todos
    </div>
  )
}
