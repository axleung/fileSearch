import { useState } from "react";

export default function Search() {
  const [keyword, setKeyword] = useState("");
  const [results, setResults] = useState([]);
  const [error, setError] = useState("");

  const handleSearch = async () => {
    if (!keyword.trim() || keyword.length <= 2) {
      setError(
        "Please enter a search keyword and keyword length great than 2.",
      );
      return;
    }
    setError("");
    try {
      const response = await fetch(
        `http://localhost:8080/?keyword=${encodeURIComponent(keyword)}`,
      );
      const data = await response.json();
      setResults(data);
    } catch (err) {
      setError("Error fetching results");
    }
  };

  return (
    <div>
      <input
        type="text"
        value={keyword}
        onChange={(e) => setKeyword(e.target.value)}
        placeholder="Enter keyword"
      />
      <button onClick={handleSearch}>Search</button>
      {error && <p>{error}</p>}
      <div style={{ paddingTop: "10px", minHeight: "300px" }}>
        {results.map((result, index) => (
          <div key={index}>{result}</div>
        ))}
      </div>
    </div>
  );
}
