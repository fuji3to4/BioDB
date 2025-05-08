"use client"
import React, { useState, useEffect, useRef } from 'react';

import {
  Card,
  CardContent,
} from '@/components/ui/card';
import { Input } from "@/components/ui/input"

export interface SearchFormProps {
  onSearchAction: (params: SearchParams) => void;
}

export interface SearchParams {
  id: string;
  method: string;
  name: string;
  class: string;
  org: string;
  res: string;
}



export function SearchForm({ onSearchAction }: SearchFormProps) { //pages.tsxからonSearchAction={handleSearch}
  const [params, setParams] = useState<SearchParams>({
    id: '',
    method: '',
    name: '',
    class: '',
    org: '',
    res: '',
  });

  const prevParams = useRef<SearchParams>(params);

  useEffect(() => {
    onSearchAction(params);
  }, []);

  useEffect(() => {
    // 前回の値と現在の値を比較
    const hasChanged = Object.keys(params).some(
      key => params[key as keyof SearchParams] !== prevParams.current[key as keyof SearchParams]
    );

    if (hasChanged) {
      onSearchAction(params); // 変更があった場合にのみ実行
      prevParams.current = params; // 前回の値を更新
    }
  }, [params, onSearchAction]);


  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setParams(prev => ({ ...prev, [name]: value }));
  };

  return (
    <>
      <Card className='mb-5'>

        <CardContent>
          <div className="space-y-4 mt-4 w-lg">
            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">PDB ID:</label>
              <Input
                type="text"
                name="id"
                value={params.id}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>

            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">Method:</label>
              <Input
                type="text"
                name="method"
                value={params.method}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>

            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">Resolution:</label>
              <Input
                type="number"
                name="res"
                value={params.res}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>

            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">Class:</label>
              <Input
                type="text"
                name="class"
                value={params.class}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>

            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">Protein Name:</label>
              <Input
                type="text"
                name="name"
                value={params.name}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>

            <div className="flex items-center">
              <label className="w-32 text-sm font-medium">Organism:</label>
              <Input
                type="text"
                name="org"
                value={params.org}
                onChange={handleChange}
                className="flex-1 p-2 border rounded"
              />
            </div>
          </div>
        </CardContent>
      </Card>


    </>
  );
}

