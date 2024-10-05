import { useState, useEffect } from "react";
import axios from "axios";

function App() {
  const [posts, setPosts] = useState([]);
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // API'den post ve user verilerini çekme
    const fetchPostsAndUsers = async () => {
      try {
        const [postsResponse, usersResponse] = await Promise.all([
          axios.get("http://localhost:8080/api/posts"),
          axios.get("http://localhost:8080/api/users"),
        ]);

        const postsData = postsResponse.data;
        const usersData = usersResponse.data;

        // Post verilerine username ekleme
        const updatedPosts = postsData.map((post) => {
          const user = usersData.find((user) => user.id === post.userId);
          return { ...post, username: user ? user.username : "Unknown" };
        });

        setPosts(updatedPosts);
        setLoading(false);
      } catch (error) {
        console.error("Veri çekilirken hata oluştu:", error);
        setLoading(false);
      }
    };

    fetchPostsAndUsers();
  }, []);

  // Post silme işlevi
  const deletePost = (id) => {
    axios
      .delete(`http://localhost:8080/api/posts/${id}`)
      .then(() => {
        setPosts(posts.filter((post) => post.id !== id));
      })
      .catch((error) => {
        console.error("Silme işlemi sırasında hata oluştu:", error);
      });
  };

  if (loading) {
    return <p>Yükleniyor...</p>;
  }

  return (
    <table className="min-w-full bg-white border border-gray-200">
      <thead>
        <tr>
          <th className="py-2">Username</th>
          <th className="py-2">Title</th>
          <th className="py-2">Body</th>
          <th className="py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        {posts.map((post) => (
          <tr key={post.id} className="border-t">
            <td className="py-2 px-4">{post.username}</td>
            <td className="py-2 px-4">{post.title}</td>
            <td className="py-2 px-4">{post.body}</td>
            <td className="py-2 px-4">
              <button
                onClick={() => deletePost(post.id)}
                className="bg-red-500 text-white px-2 py-1 rounded"
              >
                (X)
              </button>
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
}

export default App;
