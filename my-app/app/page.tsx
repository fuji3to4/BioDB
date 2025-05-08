'use client'
import React, { useState } from 'react';
import { SearchForm,SearchParams } from './components/SearchForm';
import { ResultTable } from './components/ResultTable';

export default function App() {
  const [searchResults, setSearchResults] = useState([]);

  const handleSearch = async (params: SearchParams) => {
    const queryString = new URLSearchParams(params as unknown as Record<string, string>).toString();
    try {
      const response = await fetch(`http://localhost/api/search.php?${queryString}`);
      const data = await response.json();
      if (data.status === 'success') {
        setSearchResults(data.data);
        console.log('Search results:', data.data);
      }
    } catch (error) {
      console.error('Error fetching search results:', error);
    }
  };

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-3xl font-bold mb-4 text-blue-500">PDB Search</h1>
      <SearchForm onSearchAction={handleSearch} />
      <ResultTable data={searchResults} />
    </div>
  );
}