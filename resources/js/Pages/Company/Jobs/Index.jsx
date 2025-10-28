import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Index() {
  const { companies, flash } = usePage().props;

  return (
    <div className="container mx-auto p-6">
      <div className="flex items-center justify-between">
        <h1 className="text-2xl font-bold">Mis vacantes</h1>
        <Link href="/company/jobs/create" className="px-4 py-2 bg-blue-600 text-white rounded">Nueva vacante</Link>
      </div>
      <div className="mt-4 space-y-6">
        {companies.map(c => (
          <div key={c.id}>
            <h2 className="text-xl font-semibold">{c.name}</h2>
            <div className="mt-2 space-y-2">
              {(c.jobs || []).map(j => (
                <div key={j.id} className="border rounded p-3 flex items-center justify-between">
                  <div>
                    <div className="font-medium">{j.title}</div>
                    <div className="text-sm text-gray-600">{j.location} • {j.modality}</div>
                  </div>
                  <div className="text-sm">{j.is_active ? 'Activa' : 'Inactiva'}</div>
                </div>
              ))}
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}